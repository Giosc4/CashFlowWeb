<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/write_functions.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $categoryID = $_POST['id'] ?? null;

    // Validate required fields
    if (!$categoryID) {
        echo "Category ID is missing.";
        exit();
    }

    // Attempt to delete the transaction
    $result = deletePrimaryCategory($categoryID);

    if ($result) {
        header("Location: ../../client/index.php"); // Redirect to the client page after successful deletion
        exit();
    } else {
        echo "An error occurred while deleting the category. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}


?>
