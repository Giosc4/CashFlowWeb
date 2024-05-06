<?php
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['amount'], $_POST['accountId'], $_POST['primaryCategoryId'], $_POST['transactionDate'])) {
        $isExpense = isset($_POST['isExpense']);
        $amount = $_POST['amount'];
        $accountId = $_POST['accountId'];
        $primaryCategoryId = $_POST['primaryCategoryId'];
        $secondaryCategoryId = isset($_POST['secondaryCategoryId']) ? intval($_POST['secondaryCategoryId']) : 0;
        $dataTransazione = $_POST['transactionDate'];
        

        if ($accountId !== null && $primaryCategoryId !== null && $amount >= 0) {
            $isExpenseFlag = $isExpense ? 1 : 0;
            saveTransaction($isExpenseFlag, $amount, $accountId, $dataTransazione, $primaryCategoryId, $secondaryCategoryId);
            header("Location:  ../../client/index.php");
            exit();
        } else {
            $_SESSION['error'] = "Errore: Conto o categoria non trovati.";
        }
    } else {
        $_SESSION['error'] = "Errore: Tutti i campi sono obbligatori.";
    }
}



