<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../../log_in_profile_client.php");
    exit();
}

require '../../db/write_functions.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $creditID = $_POST['id'] ?? null;
    $importoCredito = $_POST['ImportoCredito'] ?? null;
    $nomeCredito = $_POST['NomeCredito'] ?? null;
    $DataConcessione = $_POST['DataConcessione'] ?? null;
    $dataEstinsione = $_POST['dataEstinsione'] ?? null;  
    $note = $_POST['Note'] ?? null;
    $IDConto = $_POST['IDConto'] ?? null;

    // Prepare data for update
    $creditData = [
        'ID' => $creditID,
        'ImportoCredito' => $importoCredito,
        'NomeCredito' => $nomeCredito,
        'DataConcessione' => $DataConcessione,
        'DataEstinsione' => $dataEstinsione, 
        'Note' => $note,
        'IDConto' => $IDConto
    ];

    echo $dataConcessione;
    if (updateCredit($creditData)) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while updating the credit. Please try again.";
        header("Location: ../../client/index.php?error=update_credit");
        exit();
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    header("Location: ../../client/index.php?error=update_credit");
    exit();
}
