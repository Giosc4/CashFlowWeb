<?php
require_once '../db/db.php';
require_once '../db/queries.php';
require_once '../server/classes.php';

function getAllTransactions()
{
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

function getAllAccounts()
{
    global $conn, $selectAllAccountsQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllAccountsQuery);

    $accounts = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
    }
    return $accounts;
}


function getAllCategoriePrimarie()
{
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

function getCategorieSecondarieFromPrimarie($primaryCategory)
{
    global $conn;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM categoriasecondaria WHERE IDPCategoriaPrimaria = '$primaryCategory'");

    $categorieSecondarie = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categorieSecondarie[] = $row;
        }
    }

    return $categorieSecondarie;
}

function getAllCategorieSecondarie()
{
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


function getAllBudgets()
{

    global $conn, $selectAllBudgetsQuery;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($selectAllBudgetsQuery);

    $budgets = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $budgets[] = $row;
        }
    }

    return $budgets;
}
function getAllObiettivi()
{

    global $conn, $queryObiettiviFinanziari;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($queryObiettiviFinanziari);

    $budgets = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $budgets[] = $row;
        }
    }

    return $budgets;
}

function getAllRisparmi()
{

    global $conn, $queryRisparmi;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($queryRisparmi);

    $budgets = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $budgets[] = $row;
        }
    }

    return $budgets;
}

function getAllDebiti()
{
    global $conn, $queryDebito;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($queryDebito);

    $debiti = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $debiti[] = $row;
        }
    }

    return $debiti;
}


function getAllCrediti()
{
    global $conn, $queryCredito;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($queryCredito);

    $debiti = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $debiti[] = $row;
        }
    }

    return $debiti;
}