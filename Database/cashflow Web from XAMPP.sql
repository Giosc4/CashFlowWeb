SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET
  time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `cashflow` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `cashflow`;

DELIMITER $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_CreateConto` (
  IN `NomeConto` VARCHAR(255),
  IN `Saldo` DECIMAL(10, 2)
) BEGIN
INSERT INTO
  Conto (NomeConto, Saldo)
VALUES
  (NomeConto, Saldo);

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_CreateProfilo` (
  IN `NomeProfilo` VARCHAR(255),
  IN `Saldo_totale` DECIMAL(10, 2),
  IN `Email` VARCHAR(255),
  IN `Password` VARCHAR(255)
) BEGIN
INSERT INTO
  Profili (NomeProfilo, Saldo_totale, Email, Password)
VALUES
  (NomeProfilo, Saldo_totale, Email, Password);

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_CreateTransazione` (
  IN `Entrata_Uscita` BOOLEAN,
  IN `Importo` DECIMAL(10, 2),
  IN `IDTemplate` INT,
  IN `IDConto` INT,
  IN `DataTransazione` DATE,
  IN `IDCategoriaPrimaria` INT,
  IN `IDCategoriaSecondaria` INT,
  IN `Descrizione` VARCHAR(255)
) BEGIN
INSERT INTO
  Transazione (
    Entrata_Uscita,
    Importo,
    IDTemplate,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria,
    IDCategoriaSecondaria,
    Descrizione
  )
VALUES
  (
    Entrata_Uscita,
    Importo,
    IDTemplate,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria,
    IDCategoriaSecondaria,
    Descrizione
  );

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_DeleteConto` (IN `IDConto` INT) BEGIN
DELETE FROM
  Conto
WHERE
  IDConto = IDConto;

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_DeleteProfilo` (IN `IDProfilo` INT) BEGIN
DELETE FROM
  Profili
WHERE
  IDProfilo = IDProfilo;

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_DeleteTransazione` (IN `ID` INT) BEGIN
DELETE FROM
  Transazione
WHERE
  ID = ID;

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_UpdateConto` (
  IN `IDConto` INT,
  IN `NomeConto` VARCHAR(255),
  IN `Saldo` DECIMAL(10, 2)
) BEGIN
UPDATE
  Conto
SET
  NomeConto = NomeConto,
  Saldo = Saldo
WHERE
  IDConto = IDConto;

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_UpdateProfilo` (
  IN `IDProfilo` INT,
  IN `NomeProfilo` VARCHAR(255),
  IN `Saldo_totale` DECIMAL(10, 2),
  IN `Email` VARCHAR(255),
  IN `Password` VARCHAR(255)
) BEGIN
UPDATE
  Profili
SET
  NomeProfilo = NomeProfilo,
  Saldo_totale = Saldo_totale,
  Email = Email,
  Password = Password
WHERE
  IDProfilo = IDProfilo;

END $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_UpdateTransazione` (
  IN `ID` INT,
  IN `Entrata_Uscita` BOOLEAN,
  IN `Importo` DECIMAL(10, 2),
  IN `IDTemplate` INT,
  IN `IDConto` INT,
  IN `DataTransazione` DATE,
  IN `IDCategoriaPrimaria` INT,
  IN `IDCategoriaSecondaria` INT,
  IN `Descrizione` VARCHAR(255)
) BEGIN
UPDATE
  Transazione
SET
  Entrata_Uscita = Entrata_Uscita,
  Importo = Importo,
  IDTemplate = IDTemplate,
  IDConto = IDConto,
  DataTransazione = DataTransazione,
  IDCategoriaPrimaria = IDCategoriaPrimaria,
  IDCategoriaSecondaria = IDCategoriaSecondaria,
  Descrizione = Descrizione
WHERE
  ID = ID;

END $ $ DELIMITER;

CREATE TABLE `assconti` (
  `IDAssegnazione` int(11) NOT NULL,
  `IDProfilo` int(11) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `budgetmax` (
  `IDBudget` int(11) NOT NULL,
  `NomeBudget` varchar(255) DEFAULT NULL,
  `ImportoMax` decimal(10, 2) DEFAULT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataFine` date DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `categoriaprimaria` (
  `ID` int(11) NOT NULL,
  `NomeCategoria` varchar(255) DEFAULT NULL,
  `DescrizioneCategoria` varchar(255) DEFAULT NULL,
  `IDBudget` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `categoriasecondaria` (
  `ID` int(11) NOT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `NomeCategoria` varchar(255) DEFAULT NULL,
  `DescrizioneCategoria` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `conto` (
  `IDConto` int(11) NOT NULL,
  `NomeConto` varchar(255) DEFAULT NULL,
  `Saldo` decimal(10, 2) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `credit` (
  `ID` int(11) NOT NULL,
  `ImportoCredito` decimal(10, 2) DEFAULT NULL,
  `NomeImporto` varchar(255) DEFAULT NULL,
  `DataConcessione` date DEFAULT NULL,
  `DataEstinsione` date DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `debit` (
  `ID` int(11) NOT NULL,
  `ImportoDebito` decimal(10, 2) DEFAULT NULL,
  `NomeImporto` varchar(255) DEFAULT NULL,
  `DataConcessione` date DEFAULT NULL,
  `DataEstinsione` date DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `obiettivifinanziari` (
  `ID` int(11) NOT NULL,
  `NomeObiettivo` varchar(255) DEFAULT NULL,
  `ImportoObiettivo` decimal(10, 2) DEFAULT NULL,
  `DataScadenza` date DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `profili` (
  `IDProfilo` int(11) NOT NULL,
  `NomeProfilo` varchar(255) DEFAULT NULL,
  `Saldo_totale` decimal(10, 2) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `risparmi` (
  `ID` int(11) NOT NULL,
  `ImportoRisparmiato` decimal(10, 2) DEFAULT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataFine` date DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `template_transazioni` (
  `IDTemplate` int(11) NOT NULL,
  `NomeTemplate` varchar(255) DEFAULT NULL,
  `Entrata_Uscita` tinyint(1) DEFAULT NULL,
  `Importo` decimal(10, 2) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `IDCategoriaSecondaria` int(11) DEFAULT NULL,
  `Descrizione` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `transazione` (
  `ID` int(11) NOT NULL,
  `Entrata_Uscita` tinyint(1) DEFAULT NULL,
  `Importo` decimal(10, 2) DEFAULT NULL,
  `IDTemplate` int(11) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `DataTransazione` date DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `IDCategoriaSecondaria` int(11) DEFAULT NULL,
  `Descrizione` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DELIMITER $ $ CREATE TRIGGER `aggiornaSaldoDopoAggiornamento`
AFTER
UPDATE
  ON `transazione` FOR EACH ROW BEGIN
UPDATE
  Conto
SET
  Saldo = Saldo - CASE
    WHEN OLD.Entrata_Uscita = 1 THEN OLD.Importo
    ELSE - OLD.Importo
  END + CASE
    WHEN NEW.Entrata_Uscita = 1 THEN NEW.Importo
    ELSE - NEW.Importo
  END
WHERE
  IDConto = NEW.IDConto;

END $ $ DELIMITER;

DELIMITER $ $ CREATE TRIGGER `aggiornaSaldoDopoEliminazione`
AFTER
  DELETE ON `transazione` FOR EACH ROW BEGIN
UPDATE
  Conto
SET
  Saldo = CASE
    WHEN OLD.Entrata_Uscita = 1 THEN Saldo - OLD.Importo
    ELSE Saldo + OLD.Importo
  END
WHERE
  IDConto = OLD.IDConto;

END $ $ DELIMITER;

DELIMITER $ $ CREATE TRIGGER `aggiornaSaldoDopoInserimento`
AFTER
INSERT
  ON `transazione` FOR EACH ROW BEGIN
UPDATE
  Conto
SET
  Saldo = CASE
    WHEN NEW.Entrata_Uscita = 1 THEN Saldo + NEW.Importo
    ELSE Saldo - NEW.Importo
  END
WHERE
  IDConto = NEW.IDConto;

END $ $ DELIMITER;

ALTER TABLE
  `assconti`
ADD
  PRIMARY KEY (`IDAssegnazione`),
ADD
  KEY `IDProfilo` (`IDProfilo`),
ADD
  KEY `IDConto` (`IDConto`);

ALTER TABLE
  `budgetmax`
ADD
  PRIMARY KEY (`IDBudget`);

ALTER TABLE
  `categoriaprimaria`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `IDBudget` (`IDBudget`);

ALTER TABLE
  `categoriasecondaria`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `IDCategoriaPrimaria` (`IDCategoriaPrimaria`);

ALTER TABLE
  `conto`
ADD
  PRIMARY KEY (`IDConto`);

ALTER TABLE
  `credit`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `fk_credit_conto` (`IDConto`);

ALTER TABLE
  `debit`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `fk_debit_conto` (`IDConto`);

ALTER TABLE
  `obiettivifinanziari`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `fk_obiettivi_conto` (`IDConto`);

ALTER TABLE
  `profili`
ADD
  PRIMARY KEY (`IDProfilo`);

ALTER TABLE
  `risparmi`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `fk_risparmi_conto` (`IDConto`);

ALTER TABLE
  `template_transazioni`
ADD
  PRIMARY KEY (`IDTemplate`),
ADD
  KEY `IDConto` (`IDConto`),
ADD
  KEY `IDCategoriaPrimaria` (`IDCategoriaPrimaria`),
ADD
  KEY `IDCategoriaSecondaria` (`IDCategoriaSecondaria`);

ALTER TABLE
  `transazione`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `IDTemplate` (`IDTemplate`),
ADD
  KEY `IDConto` (`IDConto`),
ADD
  KEY `IDCategoriaPrimaria` (`IDCategoriaPrimaria`),
ADD
  KEY `IDCategoriaSecondaria` (`IDCategoriaSecondaria`);

ALTER TABLE
  `assconti`
ADD
  CONSTRAINT `assconti_ibfk_1` FOREIGN KEY (`IDProfilo`) REFERENCES `profili` (`IDProfilo`),
ADD
  CONSTRAINT `assconti_ibfk_2` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`);

ALTER TABLE
  `categoriaprimaria`
ADD
  CONSTRAINT `categoriaprimaria_ibfk_1` FOREIGN KEY (`IDBudget`) REFERENCES `budgetmax` (`IDBudget`);

ALTER TABLE
  `categoriasecondaria`
ADD
  CONSTRAINT `categoriasecondaria_ibfk_1` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`);

ALTER TABLE
  `credit`
ADD
  CONSTRAINT `fk_credit_conto` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`);

ALTER TABLE
  `debit`
ADD
  CONSTRAINT `fk_debit_conto` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`);

ALTER TABLE
  `obiettivifinanziari`
ADD
  CONSTRAINT `fk_obiettivi_conto` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`);

ALTER TABLE
  `risparmi`
ADD
  CONSTRAINT `fk_risparmi_conto` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`);

ALTER TABLE
  `template_transazioni`
ADD
  CONSTRAINT `template_transazioni_ibfk_1` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`),
ADD
  CONSTRAINT `template_transazioni_ibfk_2` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`),
ADD
  CONSTRAINT `template_transazioni_ibfk_3` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`);

ALTER TABLE
  `transazione`
ADD
  CONSTRAINT `transazione_ibfk_1` FOREIGN KEY (`IDTemplate`) REFERENCES `template_transazioni` (`IDTemplate`),
ADD
  CONSTRAINT `transazione_ibfk_2` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`IDConto`),
ADD
  CONSTRAINT `transazione_ibfk_3` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`),
ADD
  CONSTRAINT `transazione_ibfk_4` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`);