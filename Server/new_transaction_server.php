<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['amount'], $_POST['accountId'], $_POST['primaryCategoryId'], $_POST['secondaryCategoryId'], $_POST['transactionDate'])) {
        $isExpense = isset($_POST['isExpense']) && $_POST['isExpense'] === 'on';
        $amount = floatval($_POST['amount']);
        $accountId = intval($_POST['accountId']);
        $primaryCategoryId = intval($_POST['primaryCategoryId']);
        $secondaryCategoryId = intval($_POST['secondaryCategoryId']);
        $transactionDate = $_POST['transactionDate'];

        $account = getAccountById($accountId);
        $primaryCategory = getCategoryById($primaryCategoryId);
        $secondaryCategory = getCategoryById($secondaryCategoryId);

        if ($account !== null && $primaryCategory !== null && $secondaryCategory !== null) {
            saveTransaction($isExpense, $amount, $account, $primaryCategory, $secondaryCategory, $transactionDate);
            header("Location: ../client/index.php");
            exit();
        } else {
            header("Location: ../error.php?error=invalidInput");
            exit();
        }
    } else {
        header("Location: ../error1.php?error=missingFields");
        exit();
    }
}


function getAccountById($accountId)
{
    $accounts = getAllConti();

    foreach ($accounts as $account) {
        if ($account['IDConto'] == $accountId) {
            return $account;
        }
    }

    return null;
}

function getCategoryById($categoryId)
{
    $categories = array_merge(getAllPrimaryCategories(), getAllSecondaryCategories());

    foreach ($categories as $category) {
        if ($category['ID'] == $categoryId) {
            return $category;
        }
    }

    return null;
}
