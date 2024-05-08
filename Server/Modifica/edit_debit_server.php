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
    $debtID = $_POST['id'] ?? null;
    $importoDebito = $_POST['ImportoDebito'] ?? null;
    $nomeImporto = $_POST['NomeImporto'] ?? null;
    $dataConcessione = $_POST['DataConcessione'] ?? null;
    $dataEstinsione = $_POST['DataEstinsione'] ?? null;
    $note = $_POST['Note'] ?? null;
    $IDConto = $_POST['IDConto'] ?? null;

    // Validate required fields
    if (!$debtID || !$importoDebito || !$nomeImporto || !$dataConcessione || !$dataEstinsione || !$IDConto) {
        echo "required fields are missing or have invalid data.";
        exit();
    }

    // Prepare data for update
    $debtData = [
        'ID' => $debtID,
        'ImportoDebito' => $importoDebito,
        'NomeImporto' => $nomeImporto,
        'DataConcessione' => $dataConcessione,
        'DataEstinsione' => $dataEstinsione,
        'Note' => $note,
        'IDConto' => $IDConto
    ];

    // Attempt to update the debt
    $result = updateDebito($debtData);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while updating the debt. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}
