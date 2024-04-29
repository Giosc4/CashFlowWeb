<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['amount'], $_POST['accountId'], $_POST['categoryId'])) {
        $isExpense = isset($_POST['isExpense']) ? true : false;
        $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.0;
        $accountId = isset($_POST['accountId']) ? intval($_POST['accountId']) : null;
        $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : null;
        $positionCity = 1; // Default value
        $transactionDate = isset($_POST['transactionDate']) ? $_POST['transactionDate'] : date("Y-m-d");

        $account = getAccountById($accountId);
        $category = getCategoryById($categoryId);

        if ($accountId !== null && $categoryId !== null) {
            saveTransaction($isExpense, $amount, $account, $category, $positionCity, $transactionDate);
            header("Location: ../client/index.php");
            exit();
        } else {
            header("Location: ../error.php");
            exit();
        }
    } else {
        header("Location: ../error1.php");
        exit();
    }
}

function getAccountById($accountId)
{
    $accounts = getAllConti();

    foreach ($accounts as $account) {
        if (property_exists($account, 'id') && $account['id'] == $accountId) {
            return $account;
        }
    }

    return null;
}

function getCategoryById($categoryId)
{
    $categories = getAllPrimaryCategories();

    foreach ($categories as $category) {
        if ($category['id'] == $categoryId) {
            return $category;
        }
    }

    return null;
}
