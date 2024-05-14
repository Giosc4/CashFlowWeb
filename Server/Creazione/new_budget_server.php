<?php
session_start();
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $budgetName = $_POST['budgetName'];
    $amount = $_POST['amount'];
    $budgetStartDate = $_POST['budgetStartDate'];
    $budgetEndDate = $_POST['budgetEndDate'];
    $primaryCategoryId = $_POST['primaryCategoryId'];

    try {
        createBudget($budgetName, $amount, $budgetStartDate, $budgetEndDate, $primaryCategoryId);
        header("Location: ../../client/index.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == '45000') {
            $_SESSION['error'] = "Il budget inserito è già stato superato.";
            header("Location: ../../client/index.php?error=budgetLimitExceeded");
        } else {
            $_SESSION['error'] = "Errore durante la creazione del budget: " . $e->getMessage();
            header("Location: ../../client/index.php?error=errorCreatingBudget");
        }
        exit();
    }
}
