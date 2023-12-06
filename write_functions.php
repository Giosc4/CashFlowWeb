<?php
require_once 'db_connection.php';
require_once 'queries.php';

function saveTransaction($isExpense, $amount, $accountId, $categoryId, $positionId, $transactionDate)
{
    global $conn, $insertTransactionQuery;

    $stmt = $conn->prepare($insertTransactionQuery);
    $stmt->bind_param("sdiiss", $isExpense, $amount, $accountId, $categoryId, $positionId, $transactionDate);
    $stmt->execute();
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
