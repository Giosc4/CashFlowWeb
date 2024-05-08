<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';




// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $budgetID = $_POST['id'] ?? null;
    $nomeBudget = $_POST['NomeBudget'] ?? null;
    $importoMax = $_POST['ImportoMax'] ?? null;
    $dataInizio = $_POST['DataInizio'] ?? null;
    $dataFine = $_POST['DataFine'] ?? null;
    $primaryCategoryID = $_POST['IDPrimaryCategory'] ?? null;

    // Validate required fields
    if (!$budgetID || !$nomeBudget || $importoMax <= 0 || !$dataInizio || !$dataFine || !$primaryCategoryID) {
        echo "required fields are missing or have invalid data.";
        exit();
    }

    // Prepare data for update
    $budgetData = [
        'ID' => $budgetID,
        'NomeBudget' => $nomeBudget,
        'ImportoMax' => $importoMax,
        'DataInizio' => $dataInizio,
        'DataFine' => $dataFine,
        'IDPrimaryCategory' => $primaryCategoryID
    ];

    // Attempt to update the budget
    $result = updateBudget($budgetData);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while updating the budget. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}
?>
