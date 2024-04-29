<?php
require_once '../db/db_connection.php';
require_once '../db/queries.php';
require_once '../server/classes.php';

function saveTransaction($isExpense, $amount, $account, $category, $positionCity, $transactionDate)
{
    global $conn, $insertTransactionQuery;

    $stmt = $conn->prepare($insertTransactionQuery);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    // Ottenere gli ID dell'account e della categoria
    $accountID = $account->id;
    $categoryID = $category->id;

    $stmt->bind_param("idiiis", $isExpense, $amount, $accountID, $categoryID, $positionCity, $transactionDate);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }
    $stmt->close();
}


function createConto($nome, $saldo)
{
    global $conn, $insertContoQuery;

    $stmt = $conn->prepare($insertContoQuery);
    $stmt->bind_param("sd", $nome, $saldo);
    if (!$stmt->execute()) {
        die('Errore durante l\'inserimento del conto: ' . $stmt->error);
    }
    $stmt->close();
}

function createCategory($categoryName)
{
    global $conn, $insertCategoryQuery;

    $stmt = $conn->prepare($insertCategoryQuery);
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $stmt->close();
}

function createPosition($longitude, $latitude, $cityName)
{
    global $conn, $insertPositionQuery;

    $stmt = $conn->prepare($insertPositionQuery);
    $stmt->bind_param("dds", $longitude, $latitude, $cityName);
    $stmt->execute();
    $stmt->close();
}

function createRisparmio($amount, $risparmioDateInizio, $risparmioDateFine, $contoId)
{
    global $conn, $insertRisparmioQuery;

    $query = $insertRisparmioQuery;
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("dssi", $amount, $risparmioDateInizio, $risparmioDateFine, $contoId);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}

function createObiettivo($name, $amount, $date_inizio, $conto_id)
{
    global $conn, $insertObiettivoQuery;

    $stmt = $conn->prepare($insertObiettivoQuery);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sdsi", $name, $amount, $date_inizio, $conto_id);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}
