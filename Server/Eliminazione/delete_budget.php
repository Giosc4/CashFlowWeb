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
    $budgetID = $_POST['id'] ?? null;

    // Validate required fields
    if (!$budgetID) {
        echo "Budget ID is missing.";
        exit();
    }

    // Attempt to delete the budget
    $result = deleteBudget($budgetID);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while deleting the budget. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}
