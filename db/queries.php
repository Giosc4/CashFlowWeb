<?php
$insertTransactionQuery = "INSERT INTO `transaction` (isExpense, amount, account_id, category_id, position_id, transactionDate) VALUES (?, ?, ?, ?, ?, ?)";
$insertContoQuery = "INSERT INTO `conto` (`NomeConto`, `Saldo`) VALUES (?, ?)";
$insertCategoryQuery = "INSERT INTO `categories` (`name`) VALUES (?)";
$insertPositionQuery = "INSERT INTO `position` (`longitude`, `latitude`, `city_name`) VALUES (?, ?, ?)";
$insertRisparmioQuery =  "INSERT INTO risparmi (ImportoRisparmiato, DataInizio, DataFine, IDConto) VALUES (?, ?, ?, ?)";
$insertObiettivoQuery = "INSERT INTO obiettivifinanziari (NomeObiettivo, ImportoObiettivo, DataScadenza,  IDConto) VALUES (?, ?,  ?, ?)";

$selectAllTransactionsQuery = "SELECT * FROM `transazione`";
$selectAllContiQuery = "SELECT * FROM `conto`";
$selectAllPrimaryCategoriesQuery = "SELECT * FROM `categoriaprimaria`";
$selectAllRisparmiQuery = "SELECT * FROM `risparmi`";
$selectAllObiettiviQuery = "SELECT * FROM `obiettivifinanziari`";

$selectAccountByNameQuery = "SELECT * FROM `account` WHERE `name` = ?";
$selectCategoryByNameQuery = "SELECT * FROM `categories` WHERE `name` = ?";
$selectIdContoFromNomeQuery = "SELECT `IDConto` FROM `conto` WHERE `NomeConto` = ?";

$selectAccountByIdQuery = "SELECT * FROM `account` WHERE `id` = ?";
$selectCategoryByIdQuery = "SELECT * FROM `categories` WHERE `id` = ?";
