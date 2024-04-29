<?php
require_once '../db/db_connection.php';
require_once '../db/queries.php';


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


function getAllAccounts()
{
    global $conn, $selectAllAccountsQuery;

    $result = $conn->query($selectAllAccountsQuery);

    $accounts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (isset($row['id'])) {
                $accounts[] = new Account($row['id'], $row['name']);
            } else {
                echo "Errore: Chiave 'id' non presente nell'array.";
            }
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
            if (isset($row['id'])) {
                $categories[] = new Categories($row['id'], $row['name']);
            } else {
                echo "Errore: Chiave 'id' non presente nell'array.";
            }
        }
    }
    return $categories;
}
