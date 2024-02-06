<?php
require_once '../db/db.php';
require_once '../db/queries.php';
require_once '../server/classes.php';


function getAllTransactions() {
    global $conn, $selectAllTransactionsQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllTransactionsQuery);

    $transactions = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }

    return $transactions;
}

function getAllPositions() {
    global $conn, $selectAllPositionsQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllPositionsQuery);

    $positions = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $positions[] = $row;
        }
    }

    return $positions;
}

function getAllAccounts() {
    global $conn, $selectAllAccountsQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllAccountsQuery);

    $accounts = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Assuming Account class constructor correctly takes parameters as (id, name)
            // Adjust parameter names as per your Account class constructor
            $accounts[] = new Account($row['IDAccount'], $row['NomeAccount'], $row['Saldo'], $row['IDRisparmio'], $row['IDSpesaRicorrente'], $row['IDPrestito'], $row['IDObiettivo'], $row['IDCredito']);
        }
    }

    return $accounts;
}


function getAllCategoriePrimarie() {
    global $conn, $selectAllCategoriePrimarieQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllCategoriePrimarieQuery);

    $categoriePrimarie = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categoriePrimarie[] = $row;
        }
    }

    return $categoriePrimarie;
}

function getAllCategorieSecondarie() {
    global $conn, $selectAllCategorieSecondarieQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllCategorieSecondarieQuery);

    $categorieSecondarie = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categorieSecondarie[] = $row;
        }
    }

    return $categorieSecondarie;
}