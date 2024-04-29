<?php
$insertTransactionQuery = "INSERT INTO `transaction` (isExpense, amount, account_id, category_id, position_id, transactionDate) VALUES (?, ?, ?, ?, ?, ?)";
$insertAccountQuery = "INSERT INTO `account` (`name`) VALUES (?)";
$insertCategoryQuery = "INSERT INTO `categories` (`name`) VALUES (?)";
$insertPositionQuery = "INSERT INTO `position` (`longitude`, `latitude`, `city_name`) VALUES (?, ?, ?)";

$selectAllTransactionsQuery = "SELECT * FROM `transazione`";
$selectAllAccountsQuery = "SELECT * FROM `conto`";
$selectAllCategoriesQuery = "SELECT * FROM `categoriaprimaria`";
$selectAccountByNameQuery = "SELECT * FROM `account` WHERE `name` = ?";
$selectCategoryByNameQuery = "SELECT * FROM `categories` WHERE `name` = ?";

$selectAccountByIdQuery = "SELECT * FROM `account` WHERE `id` = ?";
$selectCategoryByIdQuery = "SELECT * FROM `categories` WHERE `id` = ?";
