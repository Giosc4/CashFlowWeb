<?php
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['amount'], $_POST['accountId'], $_POST['primaryCategoryId'], $_POST['transactionDate'])) {
        $isExpense = isset($_POST['isExpense']) && $_POST['isExpense'] === 'on';
        $amount = $_POST['amount'];
        $accountId = $_POST['accountId'];
        $primaryCategoryId = $_POST['primaryCategoryId'];
        $secondaryCategoryId = isset($_POST['secondaryCategoryId']) ? intval($_POST['secondaryCategoryId']) : null;
        $transactionDate = $_POST['transactionDate'];

        if ($accountId !== null && $primaryCategoryId !== null && $amount > 0) {
            $isExpenseFlag = $isExpense ? 1 : 0;
            $secondaryCategoryId = $secondaryCategoryId ? $secondaryCategoryId : 0;
            saveTransaction($isExpenseFlag, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $transactionDate);
            header("Location:  ../../client/index.php");
            exit();
        } else {
            $_SESSION['error'] = "Errore: Conto o categoria non trovati.";
        }
    } else {
        $_SESSION['error'] = "Errore: Tutti i campi sono obbligatori.";
    }
}


function getAccountById($accountId)
{
    $accounts = getAllConti();

    foreach ($accounts as $account) {
        if ($account['ID'] == $accountId) {
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
