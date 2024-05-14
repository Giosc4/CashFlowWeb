<?php
session_start();
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['amount'], $_POST['accountId'], $_POST['primaryCategoryId'], $_POST['transactionDate'])) {
        $isExpense = isset($_POST['isExpense']);
        $amount = $_POST['amount'];
        $accountId = $_POST['accountId'];
        $primaryCategoryId = $_POST['primaryCategoryId'];
        $secondaryCategoryId = isset($_POST['secondaryCategoryId']) && $_POST['secondaryCategoryId'] !== '' ? intval($_POST['secondaryCategoryId']) : NULL;
        $dataTransazione = $_POST['transactionDate'];

        if ($accountId !== null && $primaryCategoryId !== null && $amount >= 0) {
            $isExpenseFlag = $isExpense ? 1 : 0;
            try {
                $result = saveTransaction($isExpenseFlag, $amount, $accountId, $dataTransazione, $primaryCategoryId, $secondaryCategoryId);
                if ($result['success']) {
                    header("Location: ../../client/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = $result['message'];
                    header("Location: ../../client/index.php?error=budgetLimitExceeded");
                    exit();
                }
            } catch (mysqli_sql_exception $e) {
                $_SESSION['error'] = "Errore: Budget limit exceeded for this category.";
                header("Location: ../../client/index.php?error=budgetLimitExceeded");
                exit();
            }
        } else {
            $_SESSION['error'] = "Errore: Conto o categoria non trovati.";
            header("Location: ../../client/index.php?error=missingAccountOrCategory");
            exit();
        }
    } else {
        $_SESSION['error'] = "Errore: Tutti i campi sono obbligatori.";
        header("Location: ../../client/index.php?error=missingFields");
        exit();
    }
}
