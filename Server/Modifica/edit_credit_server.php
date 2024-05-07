<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require '../../db/write_functions.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $creditID = $_POST['id'] ?? null;
    $importoCredito = $_POST['ImportoCredito'] ?? null;
    $nomeCredito = $_POST['NomeCredito'] ?? null;
    $dataAccredito = $_POST['DataAccredito'] ?? null;
    $dataEstinsione = $_POST['DataEstinsione'] ?? null;  // Added field
    $note = $_POST['Note'] ?? null;
    $IDConto = $_POST['IDConto'] ?? null;

    // Validate required fields
    if (!$creditID || !$importoCredito || !$nomeCredito || !$dataAccredito || !$dataEstinsione || !$IDConto) {
        echo "Required fields are missing or have invalid data.";
        exit();
    }

    // Prepare data for update
    $creditData = [
        'ID' => $creditID,
        'ImportoCredito' => $importoCredito,
        'NomeCredito' => $nomeCredito,
        'DataAccredito' => $dataAccredito,
        'DataEstinsione' => $dataEstinsione, // Correctly pass the new date field
        'Note' => $note,
        'IDConto' => $IDConto
    ];

    // Attempt to update the credit
    $result = updateCredit($creditData);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while updating the credit. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}
