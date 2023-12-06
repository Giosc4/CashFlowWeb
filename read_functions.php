<?php
require_once 'db_connection.php';
require_once 'queries.php';


function getAllTransactions()
{
    global $conn, $selectAllTransactionsQuery;

    $result = $conn->query($selectAllTransactionsQuery);

    $transactions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }

    return $transactions;
}

function getAllPositions()
{
    global $conn, $selectAllPositionsQuery;

    $result = $conn->query($selectAllPositionsQuery);

    $Positions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Positions[] = $row;
        }
    }

    return $Positions;
}
function getAllAccounts()
{
    global $conn, $selectAllAccountsQuery;

    $result = $conn->query($selectAllAccountsQuery);

    $accounts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
    }

    return $accounts;
}

function getAllCategories()
{
    global $conn, $selectAllCategoriesQuery;

    $result = $conn->query($selectAllCategoriesQuery);

    $categories = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    return $categories;
}
// read_functions.php

function getAccountById($accountId) {
    $accounts = getAllAccounts(); 

    foreach ($accounts as $account) {
        if (isset($account['id']) && $account['id'] == $accountId) {
            return $account;
        }
    }

    // Debug: stampa l'ID cercato
    echo "Debug getAccountById: Account con ID $accountId non trovato.";
    return null; // Restituisci null se l'account non è stato trovato
}

function getCategoryById($categoryId) {
    $categories = getAllCategories(); 

    foreach ($categories as $category) {
        if (isset($category['id']) && $category['id'] == $categoryId) {
            return $category;
        }
    }

    // Debug: stampa l'ID cercato
    echo "Debug getCategoryById: Categoria con ID $categoryId non trovata.";
    return null; // Restituisci null se la categoria non è stata trovata
}
