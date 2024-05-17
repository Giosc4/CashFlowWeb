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

a DECLARE PrimaryCategoryID INT;

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

END $ $ DROP PROCEDURE IF EXISTS `AssociateProfileToCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `AssociateProfileToCategory` (
  IN `_IDProfilo` INT,
  IN `_IDCategoriaPrimaria` INT
) BEGIN
INSERT INTO
  `profili_categoriaprimaria` (`IDProfilo`, `IDCategoriaPrimaria`)
VALUES
  (_IDProfilo, _IDCategoriaPrimaria);

END $ $ DROP PROCEDURE IF EXISTS `AssociateProfileToConto` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `AssociateProfileToConto` (IN `_IDProfilo` INT, IN `_IDConto` INT) BEGIN
INSERT INTO
  `assconti` (`IDProfilo`, `IDConto`)
VALUES
  (_IDProfilo, _IDConto);

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

END $ $ DROP PROCEDURE IF EXISTS `DeleteBudget` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteBudget` (IN `p_ID` INT) BEGIN
DELETE FROM
  budgetmax
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteConto` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteConto` (IN `p_ID` INT) BEGIN
DELETE FROM
  conto
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteCredito` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteCredito` (IN `p_ID` INT) BEGIN
DELETE FROM
  credit
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteDebito` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteDebito` (IN `p_ID` INT) BEGIN
DELETE FROM
  debit
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeletePrimaryCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeletePrimaryCategory` (IN `p_ID` INT) BEGIN
DELETE FROM
  categoriaprimaria
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteRisparmio` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteRisparmio` (IN `p_ID` INT) BEGIN
DELETE FROM
  risparmi
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteSecondaryCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteSecondaryCategory` (IN `p_ID` INT) BEGIN
DELETE FROM
  categoriasecondaria
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteTemplateTransaction` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteTemplateTransaction` (IN `p_ID` INT) BEGIN
DELETE FROM
  template_transazioni
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `DeleteTransaction` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `DeleteTransaction` (IN `p_ID` INT) BEGIN
DELETE FROM
  transazione
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `GenerateFinancialReport` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GenerateFinancialReport` (
  IN `startDate` DATE,
  IN `endDate` DATE,
  IN `transactionType` TINYINT,
  IN `accountId` INT,
  IN `primaryCategoryId` INT,
  IN `secondaryCategoryId` INT
) BEGIN
SELECT
  t.ID,
  t.Is_Expense,
  t.Importo,
  t.IDConto,
  t.DataTransazione,
  t.IDCategoriaPrimaria,
  t.IDCategoriaSecondaria
FROM
  transazione t
WHERE
  (
    startDate IS NULL
    OR t.DataTransazione >= startDate
  )
  AND (
    endDate IS NULL
    OR t.DataTransazione <= endDate
  )
  AND (
    transactionType = -1
    OR t.Is_Expense = transactionType
  )
  AND (
    accountId IS NULL
    OR t.IDConto = accountId
  )
  AND (
    primaryCategoryId IS NULL
    OR t.IDCategoriaPrimaria = primaryCategoryId
  )
  AND (
    secondaryCategoryId IS NULL
    OR t.IDCategoriaSecondaria = secondaryCategoryId
  );

END $ $ DROP PROCEDURE IF EXISTS `GetAllBudget` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllBudget` () BEGIN
SELECT
  *
FROM
  `budgetmax`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllCategoriePrimarie` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllCategoriePrimarie` () BEGIN
SELECT
  *
FROM
  `categoriaprimaria`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllCategorieSecondarie` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllCategorieSecondarie` () BEGIN
SELECT
  *
FROM
  `categoriasecondaria`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllConti` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllConti` () BEGIN
SELECT
  *
FROM
  `conto`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllCrediti` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllCrediti` () BEGIN
SELECT
  *
FROM
  `credit`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllDebiti` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllDebiti` () BEGIN
SELECT
  *
FROM
  `debit`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllProfili` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllProfili` () BEGIN
SELECT
  *
FROM
  `Profili`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllRisparmi` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllRisparmi` () BEGIN
SELECT
  *
FROM
  `risparmi`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllTransazioni` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllTransazioni` () BEGIN
SELECT
  *
FROM
  `transazione`;

END $ $ DROP PROCEDURE IF EXISTS `GetAllTransazioniTemplate` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetAllTransazioniTemplate` () BEGIN
SELECT
  *
FROM
  `template_transazioni`;

END $ $ DROP PROCEDURE IF EXISTS `GetBudgetByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetBudgetByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  budgetmax.*
FROM
  budgetmax
  JOIN categoriaprimaria ON budgetmax.IDPrimaryCategory = categoriaprimaria.ID
  JOIN profili_categoriaprimaria ON categoriaprimaria.ID = profili_categoriaprimaria.IDCategoriaPrimaria
  JOIN profili ON profili_categoriaprimaria.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetCategoriaPrimariaByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetCategoriaPrimariaByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  categoriaprimaria.*
FROM
  categoriaprimaria
  JOIN profili_categoriaprimaria ON categoriaprimaria.ID = profili_categoriaprimaria.IDCategoriaPrimaria
  JOIN profili ON profili_categoriaprimaria.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetCategoriaSecondariaByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetCategoriaSecondariaByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  categoriasecondaria.*
FROM
  categoriasecondaria
  JOIN categoriaprimaria ON categoriasecondaria.IDCategoriaPrimaria = categoriaprimaria.ID
  JOIN profili_categoriaprimaria ON categoriaprimaria.ID = profili_categoriaprimaria.IDCategoriaPrimaria
  JOIN profili ON profili_categoriaprimaria.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetContoByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetContoByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  conto.*
FROM
  conto
  JOIN assconti ON conto.ID = assconti.IDConto
  JOIN profili ON assconti.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetCreditiByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetCreditiByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  credit.*
FROM
  credit
  JOIN conto ON credit.IDConto = conto.ID
  JOIN assconti ON conto.ID = assconti.IDConto
  JOIN profili ON assconti.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetDebitiByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetDebitiByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  debit.*
FROM
  debit
  JOIN conto ON debit.IDConto = conto.ID
  JOIN assconti ON conto.ID = assconti.IDConto
  JOIN profili ON assconti.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetRisparmiByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetRisparmiByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  risparmi.*
FROM
  risparmi
  JOIN conto ON risparmi.IDConto = conto.ID
  JOIN assconti ON conto.ID = assconti.IDConto
  JOIN profili ON assconti.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetTransazioniByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetTransazioniByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  transazione.*
FROM
  transazione
  JOIN conto ON transazione.IDConto = conto.ID
  JOIN assconti ON conto.ID = assconti.IDConto
  JOIN profili ON assconti.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `GetTransazioniTemplateByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `GetTransazioniTemplateByEmail` (IN `email` VARCHAR(255)) BEGIN
SELECT
  template_transazioni.*
FROM
  template_transazioni
  JOIN conto ON template_transazioni.IDConto = conto.ID
  JOIN assconti ON conto.ID = assconti.IDConto
  JOIN profili ON assconti.IDProfilo = profili.ID
WHERE
  profili.Email = email;

END $ $ DROP PROCEDURE IF EXISTS `InsertBudget` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertBudget` (
  IN `_NomeBudget` VARCHAR(255),
  IN `_ImportoMax` DECIMAL(10, 2),
  IN `_DataInizio` DATE,
  IN `_DataFine` DATE,
  IN `_IDPrimaryCategory` INT
) BEGIN
INSERT INTO
  budgetmax (
    NomeBudget,
    ImportoMax,
    DataInizio,
    DataFine,
    IDPrimaryCategory
  )
VALUES
  (
    _NomeBudget,
    _ImportoMax,
    _DataInizio,
    _DataFine,
    _IDPrimaryCategory
  );

END $ $ DROP PROCEDURE IF EXISTS `InsertConto` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertConto` (
  IN `_NomeConto` VARCHAR(255),
  IN `_Saldo` DECIMAL(10, 2)
) BEGIN
INSERT INTO
  `conto` (`NomeConto`, `Saldo`)
VALUES
  (_NomeConto, _Saldo);

END $ $ DROP PROCEDURE IF EXISTS `InsertCredit` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertCredit` (
  IN `_ImportoCredito` DECIMAL(10, 2),
  IN `_NomeImporto` VARCHAR(255),
  IN `_DataConcessione` DATE,
  IN `_DataEstinsione` DATE,
  IN `_Note` TEXT,
  IN `_IDConto` INT,
  IN `_IDCategoriaPrimaria` INT
) BEGIN
INSERT INTO
  credit (
    ImportoCredito,
    NomeImporto,
    DataConcessione,
    DataEstinsione,
    Note,
    IDConto,
    IDCategoriaPrimaria
  )
VALUES
  (
    _ImportoCredito,
    _NomeImporto,
    _DataConcessione,
    _DataEstinsione,
    _Note,
    _IDConto,
    _IDCategoriaPrimaria
  );

END $ $ DROP PROCEDURE IF EXISTS `InsertDebt` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertDebt` (
  IN `_ImportoDebito` DECIMAL(10, 2),
  IN `_NomeImporto` VARCHAR(255),
  IN `_DataConcessione` DATE,
  IN `_DataEstinsione` DATE,
  IN `_Note` TEXT,
  IN `_IDConto` INT,
  IN `_IDCategoriaPrimaria` INT
) BEGIN
INSERT INTO
  debit (
    ImportoDebito,
    NomeImporto,
    DataConcessione,
    DataEstinsione,
    Note,
    IDConto,
    IDCategoriaPrimaria
  )
VALUES
  (
    _ImportoDebito,
    _NomeImporto,
    _DataConcessione,
    _DataEstinsione,
    _Note,
    _IDConto,
    _IDCategoriaPrimaria
  );

END $ $ DROP PROCEDURE IF EXISTS `InsertPrimaryCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertPrimaryCategory` (
  IN `_NomeCategoria` VARCHAR(255),
  IN `_DescrizioneCategoria` TEXT
) BEGIN
INSERT INTO
  `categoriaprimaria` (NomeCategoria, DescrizioneCategoria)
VALUES
  (_NomeCategoria, _DescrizioneCategoria);

END $ $ DROP PROCEDURE IF EXISTS `InsertProfile` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertProfile` (
  IN `_NomeProfilo` VARCHAR(255),
  IN `_Email` VARCHAR(255),
  IN `_Password` VARCHAR(255)
) BEGIN
INSERT INTO
  Profili (NomeProfilo, Email, Password)
VALUES
  (_NomeProfilo, _Email, _Password);

END $ $ DROP PROCEDURE IF EXISTS `InsertSavings` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertSavings` (
  IN `_ImportoRisparmiato` DECIMAL(10, 2),
  IN `_DataInizio` DATE,
  IN `_DataFine` DATE,
  IN `_IDConto` INT,
  IN `_IDCategoriaPrimaria` INT
) BEGIN
INSERT INTO
  risparmi (
    ImportoRisparmiato,
    DataInizio,
    DataFine,
    IDConto,
    IDCategoriaPrimaria
  )
VALUES
  (
    _ImportoRisparmiato,
    _DataInizio,
    _DataFine,
    _IDConto,
    _IDCategoriaPrimaria
  );

END $ $ DROP PROCEDURE IF EXISTS `InsertSecondaryCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertSecondaryCategory` (
  IN `_IDCategoriaPrimaria` INT,
  IN `_NomeCategoria` VARCHAR(255),
  IN `_DescrizioneCategoria` TEXT
) BEGIN
INSERT INTO
  `categoriasecondaria` (
    IDCategoriaPrimaria,
    NomeCategoria,
    DescrizioneCategoria
  )
VALUES
  (
    _IDCategoriaPrimaria,
    _NomeCategoria,
    _DescrizioneCategoria
  );

END $ $ DROP PROCEDURE IF EXISTS `InsertTransaction` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertTransaction` (
  IN `_Is_Expense` BOOLEAN,
  IN `_Importo` DECIMAL(10, 2),
  IN `_IDConto` INT,
  IN `_DataTransazione` DATE,
  IN `_IDCategoriaPrimaria` INT,
  IN `_IDCategoriaSecondaria` INT
) BEGIN
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
    _Is_Expense,
    _Importo,
    _IDConto,
    _DataTransazione,
    _IDCategoriaPrimaria,
    _IDCategoriaSecondaria
  );

END $ $ DROP PROCEDURE IF EXISTS `InsertTransactionTemplate` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `InsertTransactionTemplate` (
  IN `_NomeTemplate` VARCHAR(255),
  IN `_Is_Expense` BOOLEAN,
  IN `_Importo` DECIMAL(10, 2),
  IN `_IDConto` INT,
  IN `_IDCategoriaPrimaria` INT,
  IN `_IDCategoriaSecondaria` INT,
  IN `_Descrizione` TEXT
) BEGIN
INSERT INTO
  template_transazioni (
    NomeTemplate,
    Is_Expense,
    Importo,
    IDConto,
    IDCategoriaPrimaria,
    IDCategoriaSecondaria,
    Descrizione
  )
VALUES
  (
    _NomeTemplate,
    _Is_Expense,
    _Importo,
    _IDConto,
    _IDCategoriaPrimaria,
    _IDCategoriaSecondaria,
    _Descrizione
  );

END $ $ DROP PROCEDURE IF EXISTS `selectAccountById` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectAccountById` (IN `accountID` INT) BEGIN
SELECT
  *
FROM
  conto
WHERE
  ID = accountID;

END $ $ DROP PROCEDURE IF EXISTS `selectBudgetFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectBudgetFromID` (IN `budgetID` INT) BEGIN
SELECT
  *
FROM
  budgetmax
WHERE
  ID = budgetID;

END $ $ DROP PROCEDURE IF EXISTS `selectCategoriaPrimariaById` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectCategoriaPrimariaById` (IN `primaryID` INT) BEGIN
SELECT
  *
FROM
  categoriaprimaria
WHERE
  ID = primaryID;

END $ $ DROP PROCEDURE IF EXISTS `selectCreditFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectCreditFromID` (IN `creditID` INT) BEGIN
SELECT
  *
FROM
  credit
WHERE
  ID = creditID;

END $ $ DROP PROCEDURE IF EXISTS `selectDebitFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectDebitFromID` (IN `debitID` INT) BEGIN
SELECT
  *
FROM
  debit
WHERE
  ID = debitID;

END $ $ DROP PROCEDURE IF EXISTS `selectIdContoFromNome` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectIdContoFromNome` (IN `accountName` VARCHAR(255)) BEGIN
SELECT
  ID
FROM
  conto
WHERE
  NomeConto = accountName;

END $ $ DROP PROCEDURE IF EXISTS `selectIDProfileByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectIDProfileByEmail` (IN `userEmail` VARCHAR(255)) BEGIN
SELECT
  ID
FROM
  Profili
WHERE
  Email = userEmail;

END $ $ DROP PROCEDURE IF EXISTS `selectSavingFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectSavingFromID` (IN `savingID` INT) BEGIN
SELECT
  *
FROM
  risparmi
WHERE
  ID = savingID;

END $ $ DROP PROCEDURE IF EXISTS `selectSecondaryCategoryFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectSecondaryCategoryFromID` (IN `secondaryID` INT) BEGIN
SELECT
  *
FROM
  categoriasecondaria
WHERE
  ID = secondaryID;

END $ $ DROP PROCEDURE IF EXISTS `selectSecondaryFromPrimary` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectSecondaryFromPrimary` (IN `primaryID` INT) BEGIN
SELECT
  *
FROM
  categoriasecondaria
WHERE
  IDCategoriaPrimaria = primaryID;

END $ $ DROP PROCEDURE IF EXISTS `selectTemplateTransactionFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectTemplateTransactionFromID` (IN `templateID` INT) BEGIN
SELECT
  *
FROM
  template_transazioni
WHERE
  ID = templateID;

END $ $ DROP PROCEDURE IF EXISTS `selectTransactionFromID` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectTransactionFromID` (IN `transactionID` INT) BEGIN
SELECT
  *
FROM
  transazione
WHERE
  ID = transactionID;

END $ $ DROP PROCEDURE IF EXISTS `selectUserByEmail` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `selectUserByEmail` (IN `userEmail` VARCHAR(255)) BEGIN
SELECT
  *
FROM
  Profili
WHERE
  Email = userEmail;

END $ $ DROP PROCEDURE IF EXISTS `UpdateBudget` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateBudget` (
  IN `p_NomeBudget` VARCHAR(255),
  IN `p_ImportoMax` DECIMAL(10, 2),
  IN `p_DataInizio` DATE,
  IN `p_DataFine` DATE,
  IN `p_IDPrimaryCategory` INT,
  IN `p_ID` INT
) BEGIN
UPDATE
  budgetmax
SET
  NomeBudget = p_NomeBudget,
  ImportoMax = p_ImportoMax,
  DataInizio = p_DataInizio,
  DataFine = p_DataFine,
  IDPrimaryCategory = p_IDPrimaryCategory
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateConto` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateConto` (
  IN `p_NomeConto` VARCHAR(255),
  IN `p_Saldo` DECIMAL(10, 2),
  IN `p_ID` INT
) BEGIN
UPDATE
  conto
SET
  NomeConto = p_NomeConto,
  Saldo = p_Saldo
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateCredito` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateCredito` (
  IN `p_ImportoCredito` DECIMAL(10, 2),
  IN `p_NomeImporto` VARCHAR(255),
  IN `p_DataConcessione` DATE,
  IN `p_DataEstinsione` DATE,
  IN `p_Note` TEXT,
  IN `p_IDConto` INT,
  IN `p_IDCategoriaPrimaria` INT,
  IN `p_ID` INT
) BEGIN
UPDATE
  credit
SET
  ImportoCredito = p_ImportoCredito,
  NomeImporto = p_NomeImporto,
  DataConcessione = p_DataConcessione,
  DataEstinsione = p_DataEstinsione,
  Note = p_Note,
  IDConto = p_IDConto,
  IDCategoriaPrimaria = p_IDCategoriaPrimaria
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateDebito` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateDebito` (
  IN `p_ImportoDebito` DECIMAL(10, 2),
  IN `p_NomeImporto` VARCHAR(255),
  IN `p_DataConcessione` DATE,
  IN `p_DataEstinsione` DATE,
  IN `p_Note` TEXT,
  IN `p_IDConto` INT,
  IN `p_IDCategoriaPrimaria` INT,
  IN `p_ID` INT
) BEGIN
UPDATE
  debit
SET
  ImportoDebito = p_ImportoDebito,
  NomeImporto = p_NomeImporto,
  DataConcessione = p_DataConcessione,
  DataEstinsione = p_DataEstinsione,
  Note = p_Note,
  IDConto = p_IDConto,
  IDCategoriaPrimaria = p_IDCategoriaPrimaria
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdatePrimaryCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdatePrimaryCategory` (
  IN `p_NomeCategoria` VARCHAR(255),
  IN `p_DescrizioneCategoria` TEXT,
  IN `p_ID` INT
) BEGIN
UPDATE
  categoriaprimaria
SET
  NomeCategoria = p_NomeCategoria,
  DescrizioneCategoria = p_DescrizioneCategoria
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateRisparmio` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateRisparmio` (
  IN `p_ImportoRisparmiato` DECIMAL(10, 2),
  IN `p_DataInizio` DATE,
  IN `p_DataFine` DATE,
  IN `p_IDConto` INT,
  IN `p_ID` INT
) BEGIN
UPDATE
  risparmi
SET
  ImportoRisparmiato = p_ImportoRisparmiato,
  DataInizio = p_DataInizio,
  DataFine = p_DataFine,
  IDConto = p_IDConto
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateSecondaryCategory` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateSecondaryCategory` (
  IN `p_NomeCategoria` VARCHAR(255),
  IN `p_DescrizioneCategoria` TEXT,
  IN `p_IDCategoriaPrimaria` INT,
  IN `p_ID` INT
) BEGIN
UPDATE
  categoriasecondaria
SET
  NomeCategoria = p_NomeCategoria,
  DescrizioneCategoria = p_DescrizioneCategoria,
  IDCategoriaPrimaria = p_IDCategoriaPrimaria
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateTemplateTransaction` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateTemplateTransaction` (
  IN `p_NomeTemplate` VARCHAR(255),
  IN `p_Is_Expense` BOOLEAN,
  IN `p_Importo` DECIMAL(10, 2),
  IN `p_IDConto` INT,
  IN `p_IDCategoriaPrimaria` INT,
  IN `p_IDCategoriaSecondaria` INT,
  IN `p_Descrizione` TEXT,
  IN `p_ID` INT
) BEGIN
UPDATE
  template_transazioni
SET
  NomeTemplate = p_NomeTemplate,
  Is_Expense = p_Is_Expense,
  Importo = p_Importo,
  IDConto = p_IDConto,
  IDCategoriaPrimaria = p_IDCategoriaPrimaria,
  IDCategoriaSecondaria = p_IDCategoriaSecondaria,
  Descrizione = p_Descrizione
WHERE
  ID = p_ID;

END $ $ DROP PROCEDURE IF EXISTS `UpdateTransaction` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `UpdateTransaction` (
  IN `p_Is_Expense` BOOLEAN,
  IN `p_Importo` DECIMAL(10, 2),
  IN `p_IDConto` INT,
  IN `p_DataTransazione` DATE,
  IN `p_IDCategoriaPrimaria` INT,
  IN `p_IDCategoriaSecondaria` INT,
  IN `p_ID` INT
) BEGIN
UPDATE
  transazione
SET
  Is_Expense = p_Is_Expense,
  Importo = p_Importo,
  IDConto = p_IDConto,
  DataTransazione = p_DataTransazione,
  IDCategoriaPrimaria = p_IDCategoriaPrimaria,
  IDCategoriaSecondaria = p_IDCategoriaSecondaria
WHERE
  ID = p_ID;

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

DELIMITER $ $ DROP EVENT IF EXISTS `allocateSavingsEvent` $ $ CREATE DEFINER = `root` @`localhost` EVENT `allocateSavingsEvent` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-15 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL AllocateSavingsDaily() $ $ DROP EVENT IF EXISTS `check_debit_credit_expiry_event` $ $ CREATE DEFINER = `root` @`localhost` EVENT `check_debit_credit_expiry_event` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-08 16:46:17' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN DECLARE done INT DEFAULT FALSE;

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