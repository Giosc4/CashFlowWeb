<?php
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/write_functions.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/queries.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/vdb/read_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign data sent from the form to variables
    $budgetName = $_POST['budgetName'];
    $amount = $_POST['amount'];
    $budgetStartDate = $_POST['budgetStartDate'];
    $budgetEndDate = $_POST['budgetEndDate'];
    $primaryCategoryId = $_POST['primaryCategoryId']; 

    // Function to create a new budget with a primary category
    createBudget($budgetName, $amount, $budgetStartDate, $budgetEndDate, $primaryCategoryId);
    header("Location: ../client/index.php");
    exit();
}

