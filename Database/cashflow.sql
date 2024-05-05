SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AggiornaObiettiviFinanziari` ()   BEGIN
    DECLARE obiettivo_raggiunto INT;

    UPDATE obiettivifinanziari o
    JOIN conto c ON o.IDConto = c.IDConto
    SET o.ObiettivoRaggiunto = 1
    WHERE o.ImportoObiettivo <= c.Saldo;

    SELECT ROW_COUNT() AS obiettivi_aggiornati;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CalcolaSaldoTotaleProfilo` (IN `ProfiloID` INT)   BEGIN
    DECLARE saldo_totale DECIMAL(10,2);

    SELECT SUM(Saldo) INTO saldo_totale
    FROM conto
    WHERE IDConto IN (
        SELECT IDConto
        FROM profili_conti
        WHERE IDProfilo = ProfiloID
    );

    SELECT saldo_totale;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RecuperaTransazioniPerIntervalloDate` (IN `DataInizio` DATE, IN `DataFine` DATE)   BEGIN
    SELECT *
    FROM transazione
    WHERE DataTransazione BETWEEN DataInizio AND DataFine;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RecuperaTransazioniSopraBudget` (IN `BudgetID` INT)   BEGIN
    SELECT *
    FROM transazione t
    JOIN budgetmax b ON t.IDCategoriaPrimaria = b.IDCategoriaPrimaria
    WHERE b.IDBudget = BudgetID
    AND t.Importo > b.ImportoMax;

END$$

DELIMITER ;

CREATE TABLE `assconti` (
  `IDAssegnazione` int(11) NOT NULL,
  `IDProfilo` int(11) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `budgetmax` (
  `IDBudget` int(11) NOT NULL,
  `NomeBudget` varchar(255) DEFAULT NULL,
  `ImportoMax` decimal(10,2) DEFAULT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataFine` date DEFAULT NULL,
  `IDPrimaryCategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categoriaprimaria` (
  `ID` int(11) NOT NULL,
  `NomeCategoria` varchar(255) DEFAULT NULL,
  `DescrizioneCategoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categoriasecondaria` (
  `ID` int(11) NOT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `NomeCategoria` varchar(255) DEFAULT NULL,
  `DescrizioneCategoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `conto` (
  `IDConto` int(11) NOT NULL,
  `NomeConto` varchar(255) DEFAULT NULL,
  `Saldo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `credit` (
  `ID` int(11) NOT NULL,
  `ImportoCredito` decimal(10,2) DEFAULT NULL,
  `NomeImporto` varchar(255) DEFAULT NULL,
  `DataConcessione` date DEFAULT NULL,
  `DataEstinsione` date DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `debit` (
  `ID` int(11) NOT NULL,
  `ImportoDebito` decimal(10,2) DEFAULT NULL,
  `NomeImporto` varchar(255) DEFAULT NULL,
  `DataConcessione` date DEFAULT NULL,
  `DataEstinsione` date DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `obiettivifinanziari` (
  `ID` int(11) NOT NULL,
  `NomeObiettivo` varchar(255) DEFAULT NULL,
  `ImportoObiettivo` decimal(10,2) DEFAULT NULL,
  `DataScadenza` date DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `profili` (
  `IDProfilo` int(11) NOT NULL,
  `NomeProfilo` varchar(255) DEFAULT NULL,
  `Saldo_totale` decimal(10,2) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `profili_categoriaprimaria` (
  `IDProfilo` int(11) NOT NULL,
  `IDCategoriaPrimaria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `risparmi` (
  `ID` int(11) NOT NULL,
  `ImportoRisparmiato` decimal(10,2) DEFAULT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataFine` date DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `template_transazioni` (
  `IDTemplate` int(11) NOT NULL,
  `NomeTemplate` varchar(255) DEFAULT NULL,
  `Is_Expense` tinyint(1) DEFAULT NULL,
  `Importo` decimal(10,2) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `IDCategoriaSecondaria` int(11) DEFAULT NULL,
  `Descrizione` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transazione` (
  `ID` int(11) NOT NULL,
  `Is_Expense` tinyint(1) DEFAULT NULL,
  `Importo` decimal(10,2) DEFAULT NULL,
  `IDTemplate` int(11) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `DataTransazione` date DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `IDCategoriaSecondaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
DELIMITER $$
CREATE TRIGGER `aggiornaSaldoDopoAggiornamento` AFTER UPDATE ON `transazione` FOR EACH ROW BEGIN
    UPDATE Conto
    SET Saldo = Saldo
              - CASE WHEN OLD.Entrata_Uscita = 1 THEN OLD.Importo ELSE -OLD.Importo END
              + CASE WHEN NEW.Entrata_Uscita = 1 THEN NEW.Importo ELSE -NEW.Importo END
    WHERE IDConto = NEW.IDConto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `aggiornaSaldoDopoEliminazione` AFTER DELETE ON `transazione` FOR EACH ROW BEGIN
    UPDATE Conto
    SET Saldo = CASE 
                    WHEN OLD.Entrata_Uscita = 1 THEN Saldo - OLD.Importo
                    ELSE Saldo + OLD.Importo
                END
    WHERE IDConto = OLD.IDConto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `aggiornaSaldoDopoInserimento` AFTER INSERT ON `transazione` FOR EACH ROW BEGIN
    UPDATE Conto
    SET Saldo = CASE 
                    WHEN NEW.Entrata_Uscita = 1 THEN Saldo + NEW.Importo
                    ELSE Saldo - NEW.Importo
                END
    WHERE IDConto = NEW.IDConto;
END
$$
DELIMITER ;


ALTER TABLE `assconti`
  ADD PRIMARY KEY (`IDAssegnazione`),
  ADD KEY `fk_assconti_profilo` (`IDProfilo`),
  ADD KEY `fk_assconti_conto` (`IDConto`);

ALTER TABLE `budgetmax`
  ADD PRIMARY KEY (`IDBudget`),
  ADD KEY `fk_budgetmax_primarycategory` (`IDPrimaryCategory`);

ALTER TABLE `categoriaprimaria`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `categoriasecondaria`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `categoriasecondaria_primaria_fk` (`IDCategoriaPrimaria`);

ALTER TABLE `conto`
  ADD PRIMARY KEY (`IDConto`);

ALTER TABLE `credit`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `credit_conto_fk` (`IDConto`);

ALTER TABLE `debit`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `debit_conto_fk` (`IDConto`);

ALTER TABLE `obiettivifinanziari`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `obiettivi_conto_fk` (`IDConto`);

ALTER TABLE `profili`
  ADD PRIMARY KEY (`IDProfilo`);

ALTER TABLE `profili_categoriaprimaria`
  ADD PRIMARY KEY (`IDProfilo`,`IDCategoriaPrimaria`),
  ADD KEY `fk_profili_categoriaprimaria_profilo` (`IDProfilo`),
  ADD KEY `fk_profili_categoriaprimaria_categoria` (`IDCategoriaPrimaria`);

ALTER TABLE `risparmi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `risparmi_conto_fk` (`IDConto`);

ALTER TABLE `template_transazioni`
  ADD PRIMARY KEY (`IDTemplate`),
  ADD KEY `template_transazioni_conto_fk` (`IDConto`),
  ADD KEY `template_transazioni_primaria_fk` (`IDCategoriaPrimaria`),
  ADD KEY `template_transazioni_secondaria_fk` (`IDCategoriaSecondaria`);

ALTER TABLE `transazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `transazione_template_fk` (`IDTemplate`),
  ADD KEY `transazione_conto_fk` (`IDConto`),
  ADD KEY `transazione_primaria_fk` (`IDCategoriaPrimaria`),
  ADD KEY `transazione_secondaria_fk` (`IDCategoriaSecondaria`);


ALTER TABLE `budgetmax`
  MODIFY `IDBudget` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `categoriaprimaria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `categoriasecondaria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `conto`
  MODIFY `IDConto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `credit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `debit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `obiettivifinanziari`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `profili`
  MODIFY `IDProfilo` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `risparmi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `template_transazioni`
  MODIFY `IDTemplate` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `assconti`
  ADD CONSTRAINT `fk_assconti_conto` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_assconti_profilo` FOREIGN KEY (`IDProfilo`) REFERENCES `profili` (`IDProfilo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `budgetmax`
  ADD CONSTRAINT `fk_budgetmax_primarycategory` FOREIGN KEY (`IDPrimaryCategory`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `categoriasecondaria`
  ADD CONSTRAINT `categoriasecondaria_primaria_fk` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `credit`
  ADD CONSTRAINT `credit_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `debit`
  ADD CONSTRAINT `debit_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `obiettivifinanziari`
  ADD CONSTRAINT `obiettivi_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `profili_categoriaprimaria`
  ADD CONSTRAINT `fk_profili_categoriaprimaria_categoria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_profili_categoriaprimaria_profilo` FOREIGN KEY (`IDProfilo`) REFERENCES `profili` (`IDProfilo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `risparmi`
  ADD CONSTRAINT `risparmi_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `template_transazioni`
  ADD CONSTRAINT `template_transazioni_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `template_transazioni_primaria_fk` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `template_transazioni_secondaria_fk` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `transazione`
  ADD CONSTRAINT `transazione_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transazione_primaria_fk` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transazione_secondaria_fk` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transazione_template_fk` FOREIGN KEY (`IDTemplate`) REFERENCES `template_transazioni` (`IDTemplate`) ON DELETE CASCADE ON UPDATE CASCADE;
