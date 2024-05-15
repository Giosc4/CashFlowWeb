SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET
  time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `cashflowweb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `cashflowweb`;

DELIMITER $ $ DROP PROCEDURE IF EXISTS `AllocateSavings` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `AllocateSavings` (IN `SavingsID` INT) BEGIN DECLARE StartDate DATE;

DECLARE EndDate DATE;

DECLARE TotalAmount DECIMAL(10, 2);

DECLARE AccountID INT;

DECLARE Days INT;

DECLARE DailyAmount DECIMAL(10, 2);

DECLARE PrimaryCategoryID INT;

-- Seleziona i dettagli del risparmio
SELECT
  DataInizio,
  DataFine,
  ImportoRisparmiato,
  IDConto,
  IDCategoriaPrimaria INTO StartDate,
  EndDate,
  TotalAmount,
  AccountID,
  PrimaryCategoryID
FROM
  risparmi
WHERE
  ID = SavingsID;

-- Calcola il numero di giorni (+1 per includere sia la DataInizio che la DataFine)
SET
  Days = DATEDIFF(EndDate, StartDate) + 1;

-- Evita la divisione per zero
IF Days > 0 THEN
SET
  DailyAmount = TotalAmount / Days;

-- Controlla se il saldo del conto è sufficiente
IF (
  SELECT
    Saldo
  FROM
    conto
  WHERE
    ID = AccountID
) >= DailyAmount THEN -- Inserisce una transazione solo per il giorno corrente
IF CURDATE() BETWEEN StartDate
AND EndDate THEN -- Aggiorna il saldo del conto
UPDATE
  conto
SET
  Saldo = Saldo - DailyAmount
WHERE
  ID = AccountID;

-- Aggiungi una transazione per il risparmio giornaliero
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria,
    IDCategoriaSecondaria
  )
VALUES
  (
    1,
    DailyAmount,
    AccountID,
    CURDATE(),
    PrimaryCategoryID,
    NULL
  );

END IF;

END IF;

END IF;

END $ $ DROP PROCEDURE IF EXISTS `AllocateSavingsDaily` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `AllocateSavingsDaily` () BEGIN DECLARE done INT DEFAULT FALSE;

DECLARE aSavingsID INT;

DECLARE cur CURSOR FOR
SELECT
  ID
FROM
  risparmi
WHERE
  DataFine >= CURDATE();

-- Seleziona solo i risparmi attivi
DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
  done = TRUE;

OPEN cur;

read_loop: LOOP FETCH cur INTO aSavingsID;

IF done THEN LEAVE read_loop;

END IF;

-- Chiama il procedimento per allocare i risparmi
CALL AllocateSavings(aSavingsID);

END LOOP;

CLOSE cur;

END $ $ DROP PROCEDURE IF EXISTS `CreateTransactionFromTemplate` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `CreateTransactionFromTemplate` (IN `TemplateID` INT) BEGIN DECLARE ExpenseType TINYINT;

DECLARE Amount DECIMAL(10, 2);

DECLARE AccountID INT;

DECLARE PrimaryCategoryID INT;

DECLARE SecondaryCategoryID INT;

DECLARE Description VARCHAR(255);

SELECT
  Is_Expense,
  Importo,
  IDConto,
  IDCategoriaPrimaria,
  IDCategoriaSecondaria,
  Descrizione INTO ExpenseType,
  Amount,
  AccountID,
  PrimaryCategoryID,
  SecondaryCategoryID,
  Description
FROM
  template_transazioni
WHERE
  ID = TemplateID;

INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDTemplate,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria,
    IDCategoriaSecondaria
  )
VALUES
  (
    ExpenseType,
    Amount,
    TemplateID,
    AccountID,
    CURDATE(),
    PrimaryCategoryID,
    SecondaryCategoryID
  );

END $ $ DROP PROCEDURE IF EXISTS `create_transaction_on_credit_termination` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `create_transaction_on_credit_termination` (IN `creditID` INT) BEGIN DECLARE currentDate DATE;

DECLARE creditAmount DECIMAL(10, 2);

DECLARE accountID INT;

DECLARE primaryCategoryID INT;

SET
  currentDate = CURDATE();

-- Recupera i dettagli del credito
SELECT
  ImportoCredito,
  IDConto,
  IDCategoriaPrimaria INTO creditAmount,
  accountID,
  primaryCategoryID
FROM
  credit
WHERE
  ID = creditID;

-- Crea una nuova transazione per la terminazione del credito
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria
  )
VALUES
  (
    0,
    -- Credito (entrata)
    creditAmount,
    accountID,
    currentDate,
    primaryCategoryID
  );

-- Elimina il credito dopo aver creato la transazione
DELETE FROM
  credit
WHERE
  ID = creditID;

END $ $ DROP PROCEDURE IF EXISTS `create_transaction_on_debit_termination` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `create_transaction_on_debit_termination` (IN `debitID` INT) BEGIN DECLARE currentDate DATE;

DECLARE debitAmount DECIMAL(10, 2);

DECLARE accountID INT;

DECLARE primaryCategoryID INT;

SET
  currentDate = CURDATE();

-- Recupera i dettagli del debito
SELECT
  ImportoDebito,
  IDConto,
  IDCategoriaPrimaria INTO debitAmount,
  accountID,
  primaryCategoryID
FROM
  debit
WHERE
  ID = debitID;

-- Crea una nuova transazione per la terminazione del debito
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria
  )
VALUES
  (
    1,
    -- Debito (uscita)
    debitAmount,
    accountID,
    currentDate,
    primaryCategoryID
  );

-- Elimina il debito dopo aver creato la transazione
DELETE FROM
  debit
WHERE
  ID = debitID;

END $ $ DELIMITER;

DROP TABLE IF EXISTS `assconti`;

CREATE TABLE `assconti` (
  `IDProfilo` int(11) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `budgetmax`;

CREATE TABLE `budgetmax` (
  `ID` int(11) NOT NULL,
  `NomeBudget` varchar(255) DEFAULT NULL,
  `ImportoMax` decimal(10, 2) DEFAULT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataFine` date DEFAULT NULL,
  `IDPrimaryCategory` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TRIGGER IF EXISTS `before_budget_insert_check`;

DELIMITER $ $ CREATE TRIGGER `before_budget_insert_check` BEFORE
INSERT
  ON `budgetmax` FOR EACH ROW BEGIN DECLARE TotalSpent DECIMAL(10, 2);

-- Calcola la somma totale spesa per la categoria specificata nel periodo del nuovo budget
SELECT
  SUM(t.Importo) INTO TotalSpent
FROM
  transazione t
WHERE
  t.IDCategoriaPrimaria = NEW.IDPrimaryCategory
  AND t.Is_Expense = 1
  AND t.DataTransazione BETWEEN NEW.DataInizio
  AND NEW.DataFine;

-- Verifica se la somma spesa supera il budget massimo
IF TotalSpent IS NOT NULL
AND TotalSpent > NEW.ImportoMax THEN SIGNAL SQLSTATE '45000'
SET
  MESSAGE_TEXT = 'Il budget inserito è già stato superato.';

END IF;

END $ $ DELIMITER;

DROP TABLE IF EXISTS `categoriaprimaria`;

CREATE TABLE `categoriaprimaria` (
  `ID` int(11) NOT NULL,
  `NomeCategoria` varchar(255) DEFAULT NULL,
  `DescrizioneCategoria` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `categoriasecondaria`;

CREATE TABLE `categoriasecondaria` (
  `ID` int(11) NOT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `NomeCategoria` varchar(255) DEFAULT NULL,
  `DescrizioneCategoria` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `conto`;

CREATE TABLE `conto` (
  `ID` int(11) NOT NULL,
  `NomeConto` varchar(255) DEFAULT NULL,
  `Saldo` decimal(10, 2) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `credit`;

CREATE TABLE `credit` (
  `ID` int(11) NOT NULL,
  `ImportoCredito` decimal(10, 2) DEFAULT NULL,
  `NomeImporto` varchar(255) DEFAULT NULL,
  `DataConcessione` date DEFAULT NULL,
  `DataEstinsione` date DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TRIGGER IF EXISTS `create_transaction_on_credit_insert`;

DELIMITER $ $ CREATE TRIGGER `create_transaction_on_credit_insert`
AFTER
INSERT
  ON `credit` FOR EACH ROW BEGIN
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria
  )
VALUES
  (
    1,
    NEW.ImportoCredito,
    NEW.IDConto,
    NEW.DataConcessione,
    NEW.IDCategoriaPrimaria
  );

END $ $ DELIMITER;

DROP TABLE IF EXISTS `debit`;

CREATE TABLE `debit` (
  `ID` int(11) NOT NULL,
  `ImportoDebito` decimal(10, 2) DEFAULT NULL,
  `NomeImporto` varchar(255) DEFAULT NULL,
  `DataConcessione` date DEFAULT NULL,
  `DataEstinsione` date DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TRIGGER IF EXISTS `create_transaction_on_debit_insert`;

DELIMITER $ $ CREATE TRIGGER `create_transaction_on_debit_insert`
AFTER
INSERT
  ON `debit` FOR EACH ROW BEGIN
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria
  )
VALUES
  (
    0,
    NEW.ImportoDebito,
    NEW.IDConto,
    NEW.DataConcessione,
    NEW.IDCategoriaPrimaria
  );

END $ $ DELIMITER;

DROP TABLE IF EXISTS `profili`;

CREATE TABLE `profili` (
  `ID` int(11) NOT NULL,
  `NomeProfilo` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `profili_categoriaprimaria`;

CREATE TABLE `profili_categoriaprimaria` (
  `IDProfilo` int(11) NOT NULL,
  `IDCategoriaPrimaria` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `risparmi`;

CREATE TABLE `risparmi` (
  `ID` int(11) NOT NULL,
  `ImportoRisparmiato` decimal(10, 2) DEFAULT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataFine` date DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `template_transazioni`;

CREATE TABLE `template_transazioni` (
  `ID` int(11) NOT NULL,
  `NomeTemplate` varchar(255) DEFAULT NULL,
  `Is_Expense` tinyint(1) DEFAULT NULL,
  `Importo` decimal(10, 2) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `IDCategoriaSecondaria` int(11) DEFAULT NULL,
  `Descrizione` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `transazione`;

CREATE TABLE `transazione` (
  `ID` int(11) NOT NULL,
  `Is_Expense` tinyint(1) DEFAULT NULL,
  `Importo` decimal(10, 2) DEFAULT NULL,
  `IDTemplate` int(11) DEFAULT NULL,
  `IDConto` int(11) DEFAULT NULL,
  `DataTransazione` date DEFAULT NULL,
  `IDCategoriaPrimaria` int(11) DEFAULT NULL,
  `IDCategoriaSecondaria` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

DROP TRIGGER IF EXISTS `CheckBudgetBeforeTransaction`;

DELIMITER $ $ CREATE TRIGGER `CheckBudgetBeforeTransaction` BEFORE
INSERT
  ON `transazione` FOR EACH ROW BEGIN DECLARE MaxAmount DECIMAL(10, 2);

DECLARE TotalSpent DECIMAL(10, 2);

SELECT
  ImportoMax INTO MaxAmount
FROM
  budgetmax
WHERE
  IDPrimaryCategory = NEW.IDCategoriaPrimaria
  AND CURDATE() BETWEEN DataInizio
  AND DataFine;

IF MaxAmount IS NOT NULL THEN
SELECT
  SUM(Importo) INTO TotalSpent
FROM
  transazione
WHERE
  IDCategoriaPrimaria = NEW.IDCategoriaPrimaria
  AND Is_Expense = 1;

IF (TotalSpent + NEW.Importo > MaxAmount) THEN SIGNAL SQLSTATE '45000'
SET
  MESSAGE_TEXT = 'Budget limit exceeded for this category.';

END IF;

END IF;

END $ $ DELIMITER;

DROP TRIGGER IF EXISTS `after_transazione_delete`;

DELIMITER $ $ CREATE TRIGGER `after_transazione_delete`
AFTER
  DELETE ON `transazione` FOR EACH ROW BEGIN IF OLD.Is_Expense = 1 THEN
UPDATE
  conto
SET
  Saldo = Saldo + OLD.Importo
WHERE
  ID = OLD.IDConto;

ELSE
UPDATE
  conto
SET
  Saldo = Saldo - OLD.Importo
WHERE
  ID = OLD.IDConto;

END IF;

END $ $ DELIMITER;

DROP TRIGGER IF EXISTS `after_transazione_insert`;

DELIMITER $ $ CREATE TRIGGER `after_transazione_insert`
AFTER
INSERT
  ON `transazione` FOR EACH ROW BEGIN IF NEW.Is_Expense = 1 THEN
UPDATE
  conto
SET
  Saldo = Saldo - NEW.Importo
WHERE
  ID = NEW.IDConto;

ELSE
UPDATE
  conto
SET
  Saldo = Saldo + NEW.Importo
WHERE
  ID = NEW.IDConto;

END IF;

END $ $ DELIMITER;

DROP TRIGGER IF EXISTS `after_transazione_update`;

DELIMITER $ $ CREATE TRIGGER `after_transazione_update`
AFTER
UPDATE
  ON `transazione` FOR EACH ROW BEGIN IF OLD.Is_Expense = 1 THEN
UPDATE
  conto
SET
  Saldo = Saldo + OLD.Importo
WHERE
  ID = OLD.IDConto;

ELSE
UPDATE
  conto
SET
  Saldo = Saldo - OLD.Importo
WHERE
  ID = OLD.IDConto;

END IF;

IF NEW.Is_Expense = 1 THEN
UPDATE
  conto
SET
  Saldo = Saldo - NEW.Importo
WHERE
  ID = NEW.IDConto;

ELSE
UPDATE
  conto
SET
  Saldo = Saldo + NEW.Importo
WHERE
  ID = NEW.IDConto;

END IF;

END $ $ DELIMITER;

ALTER TABLE
  `assconti`
ADD
  KEY `fk_assconti_profilo` (`IDProfilo`),
ADD
  KEY `fk_assconti_conto` (`IDConto`);

ALTER TABLE
  `budgetmax`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `fk_budgetmax_primarycategory` (`IDPrimaryCategory`);

ALTER TABLE
  `categoriaprimaria`
ADD
  PRIMARY KEY (`ID`);

ALTER TABLE
  `categoriasecondaria`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `categoriasecondaria_primaria_fk` (`IDCategoriaPrimaria`);

ALTER TABLE
  `conto`
ADD
  PRIMARY KEY (`ID`);

ALTER TABLE
  `credit`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `credit_conto_fk` (`IDConto`),
ADD
  KEY `fk_credit_categoriaprimaria` (`IDCategoriaPrimaria`);

ALTER TABLE
  `debit`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `debit_conto_fk` (`IDConto`),
ADD
  KEY `fk_debit_categoriaprimaria` (`IDCategoriaPrimaria`);

ALTER TABLE
  `profili`
ADD
  PRIMARY KEY (`ID`);

ALTER TABLE
  `profili_categoriaprimaria`
ADD
  PRIMARY KEY (`IDProfilo`, `IDCategoriaPrimaria`),
ADD
  KEY `fk_profili_categoriaprimaria_profilo` (`IDProfilo`),
ADD
  KEY `fk_profili_categoriaprimaria_categoria` (`IDCategoriaPrimaria`);

ALTER TABLE
  `risparmi`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `risparmi_conto_fk` (`IDConto`),
ADD
  KEY `fk_risparmi_categoriaprimaria` (`IDCategoriaPrimaria`);

ALTER TABLE
  `template_transazioni`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `template_transazioni_conto_fk` (`IDConto`),
ADD
  KEY `template_transazioni_primaria_fk` (`IDCategoriaPrimaria`),
ADD
  KEY `template_transazioni_secondaria_fk` (`IDCategoriaSecondaria`);

ALTER TABLE
  `transazione`
ADD
  PRIMARY KEY (`ID`),
ADD
  KEY `transazione_template_fk` (`IDTemplate`),
ADD
  KEY `transazione_conto_fk` (`IDConto`),
ADD
  KEY `transazione_primaria_fk` (`IDCategoriaPrimaria`),
ADD
  KEY `transazione_secondaria_fk` (`IDCategoriaSecondaria`);

ALTER TABLE
  `budgetmax`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `categoriaprimaria`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `categoriasecondaria`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `conto`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `credit`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `debit`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `profili`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `risparmi`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `template_transazioni`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `transazione`
MODIFY
  `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `assconti`
ADD
  CONSTRAINT `fk_assconti_conto` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_assconti_profilo` FOREIGN KEY (`IDProfilo`) REFERENCES `profili` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
  `budgetmax`
ADD
  CONSTRAINT `fk_budgetmax_primarycategory` FOREIGN KEY (`IDPrimaryCategory`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE;

ALTER TABLE
  `categoriasecondaria`
ADD
  CONSTRAINT `categoriasecondaria_primaria_fk` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
  `credit`
ADD
  CONSTRAINT `credit_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_credit_categoriaprimaria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE;

ALTER TABLE
  `debit`
ADD
  CONSTRAINT `debit_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_debit_categoriaprimaria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE;

ALTER TABLE
  `profili_categoriaprimaria`
ADD
  CONSTRAINT `fk_profili_categoriaprimaria_categoria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_profili_categoriaprimaria_profilo` FOREIGN KEY (`IDProfilo`) REFERENCES `profili` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
  `risparmi`
ADD
  CONSTRAINT `fk_risparmi_categoriaprimaria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `risparmi_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
  `template_transazioni`
ADD
  CONSTRAINT `fk_template_transazioni_primaria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_template_transazioni_primaria_new` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_template_transazioni_secondaria` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_template_transazioni_secondaria_new` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `template_transazioni_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
  `transazione`
ADD
  CONSTRAINT `fk_transazione_primaria` FOREIGN KEY (`IDCategoriaPrimaria`) REFERENCES `categoriaprimaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_transazione_secondaria` FOREIGN KEY (`IDCategoriaSecondaria`) REFERENCES `categoriasecondaria` (`ID`) ON DELETE
SET
  NULL ON UPDATE CASCADE,
ADD
  CONSTRAINT `transazione_conto_fk` FOREIGN KEY (`IDConto`) REFERENCES `conto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $ $ DROP EVENT IF EXISTS `allocateSavingsEvent` $ $ CREATE DEFINER = `root` @`localhost` EVENT `allocateSavingsEvent` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-15 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL AllocateSavingsDaily() $ $ DROP EVENT IF EXISTS `check_debit_credit_expiry_event` $ $ CREATE DEFINER = `root` @`localhost` EVENT `check_debit_credit_expiry_event` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-08 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN DECLARE done INT DEFAULT FALSE;

DECLARE debtCreditID INT;

DECLARE debtCreditType VARCHAR(10);

DECLARE cur CURSOR FOR
SELECT
  ID,
  'debit' AS type
FROM
  debit
WHERE
  DataEstinsione = CURDATE()
UNION
ALL
SELECT
  ID,
  'credit' AS type
FROM
  credit
WHERE
  DataEstinsione = CURDATE();

DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
  done = TRUE;

OPEN cur;

read_loop: LOOP FETCH cur INTO debtCreditID,
debtCreditType;

IF done THEN LEAVE read_loop;

END IF;

IF debtCreditType = 'debit' THEN
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria
  )
SELECT
  1,
  ImportoDebito,
  IDConto,
  DataEstinsione,
  IDCategoriaPrimaria
FROM
  debit
WHERE
  ID = debtCreditID;

ELSE
INSERT INTO
  transazione (
    Is_Expense,
    Importo,
    IDConto,
    DataTransazione,
    IDCategoriaPrimaria
  )
SELECT
  0,
  ImportoCredito,
  IDConto,
  DataEstinsione,
  IDCategoriaPrimaria
FROM
  credit
WHERE
  ID = debtCreditID;

END IF;

END LOOP;

CLOSE cur;

END $ $ DELIMITER;