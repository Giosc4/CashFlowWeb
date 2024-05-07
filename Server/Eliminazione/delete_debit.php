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
    $debtID = $_POST['id'] ?? null;

    // Validate required fields
    if (!$debtID) {
        echo "Debt ID is missing.";
        exit();
    }

    // Attempt to delete the debt
    $result = deleteDebito($debtID);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while deleting the debt. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}
