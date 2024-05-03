<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';



// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assegna i dati inviati dal form a variabili
    $budgetName = $_POST['budgetName'];
    $amount = $_POST['amount'];
    $budgetStartDate = $_POST['budgetStartDate'];
    $budgetEndDate = $_POST['budgetEndDate'];

    createBudget($budgetName, $amount, $budgetStartDate, $budgetEndDate);
    header("Location: ../client/index.php");
    exit();
}
