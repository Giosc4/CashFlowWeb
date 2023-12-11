<?php
require_once 'db_connection.php';
require_once 'queries.php';
require_once 'classes.php';

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


function createAccount($accountName)
{
    global $conn, $insertAccountQuery;

    $stmt = $conn->prepare($insertAccountQuery);
    $stmt->bind_param("s", $accountName);
    $stmt->execute();
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
