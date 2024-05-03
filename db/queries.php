<?php
$insertTransactionQuery = "INSERT INTO `transazione` (Entrata_Uscita, Importo, IDConto, DataTransazione, IDCategoriaPrimaria, IDCategoriaSecondaria,  Descrizione) VALUES (?, ?, ?, ?, ?, ?, ?)";$insertContoQuery = "INSERT INTO `conto` (`NomeConto`, `Saldo`) VALUES (?, ?)";
$insertContoQuery = "INSERT INTO `conto` (`NomeConto`, `Saldo`) VALUES (?, ?)";
$insertPrimaryCategoryQuery = "INSERT INTO `categoriaprimaria` (NomeCategoria, DescrizioneCategoria, IDBudget) VALUES (?, ?, ?)";
$insertSecondaryCategoryQuery = "INSERT INTO `categoriasecondaria` (IDCategoriaPrimaria, NomeCategoria, DescrizioneCategoria) VALUES (?, ?, ?)";
$insertRisparmioQuery =  "INSERT INTO risparmi (ImportoRisparmiato, DataInizio, DataFine, IDConto) VALUES (?, ?, ?, ?)";
$insertObiettivoQuery = "INSERT INTO obiettivifinanziari (NomeObiettivo, ImportoObiettivo, DataScadenza,  IDConto) VALUES (?, ?,  ?, ?)";
$insertDebitQuery = "INSERT INTO debit (ImportoDebito, NomeImporto, DataConcessione, DataEstinsione, Note, IDConto) VALUES (?, ?, ?, ?, ?, ?)";
$insertCreditQuery = "INSERT INTO credit (ImportoCredito, NomeImporto, DataConcessione, DataEstinsione, Note, IDConto) VALUES (?, ?, ?, ?, ?, ?)";
$insertBudgetQuery = "INSERT INTO budgetmax (NomeBudget, ImportoMax, DataInizio, DataFine) VALUES (?, ?, ?, ?)";
$insertTransactionTemplateQuery = "INSERT INTO template_transazioni (NomeTemplate, Entrata_Uscita, Importo, IDConto, IDCategoriaPrimaria, IDCategoriaSecondaria, Descrizione) VALUES (?, ?, ?, ?, ?, ?, ?)";
$insertProfileQuery = "INSERT INTO Profili (NomeProfilo, Email, Password) VALUES (?, ?, ?)";

$selectAllTransactionsQuery = "SELECT * FROM `transazione`";
$selectAllContiQuery = "SELECT * FROM `conto`";
$selectAllPrimaryCategoriesQuery = "SELECT * FROM `categoriaprimaria`";
$selectAllRisparmiQuery = "SELECT * FROM `risparmi`";
$selectAllObiettiviQuery = "SELECT * FROM `obiettivifinanziari`";
$selectAllDebitiQuery = "SELECT * FROM `debit`";
$selectAllCreditiQuery = "SELECT * FROM `credit`";
$selectAllSecondaryCategoriesQuery = "SELECT * FROM `categoriasecondaria`";
$selectAllBudgetQuery = "SELECT * FROM `budgetmax`";
$selectAllTransactionsTemplateQuery = "SELECT * FROM `template_transazioni`";
$selectAllProfiliQuery = "SELECT * FROM `Profili`";


$selectSecondaryFromPrimaryQuery = "SELECT * FROM `categoriasecondaria` WHERE `IDCategoriaPrimaria` = ?";

$selectAccountByNameQuery = "SELECT * FROM `account` WHERE `name` = ?";
$selectCategoryByNameQuery = "SELECT * FROM `categories` WHERE `name` = ?";
$selectIdContoFromNomeQuery = "SELECT `IDConto` FROM `conto` WHERE `NomeConto` = ?";

$selectAccountByIdQuery = "SELECT * FROM `account` WHERE `id` = ?";
$selectCategoryByIdQuery = "SELECT * FROM `categories` WHERE `id` = ?";
