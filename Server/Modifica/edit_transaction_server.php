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
    $transactionID = $_POST['id'] ?? null;
    $isExpense = isset($_POST['isExpense']) ? 1 : 0;
    $amount = $_POST['amount'] ?? null;
    $transactionDate = $_POST['date'] ?? null;
    $accountID = $_POST['accountId'] ?? null;
    $primaryCategoryID = $_POST['primaryCategoryId'] ?? null;
    $secondaryCategoryID = $_POST['secondaryCategoryId'] ?? null;
    

    // Validate required fields
    if (!$transactionID || !$accountID || !$primaryCategoryID || $amount <= 0) {
        echo "Required fields are missing or have invalid data.";
        exit();
    }

    // Prepare data for update
    $transactionData = [
        'ID' => $transactionID,
        'Is_Expense' => $isExpense,
        'Importo' => $amount,
        'DataTransazione' => $transactionDate,
        'IDConto' => $accountID,
        'IDCategoriaPrimaria' => $primaryCategoryID,
        'IDCategoriaSecondaria' => $secondaryCategoryID
    ];

    // Attempt to update the transaction
    $result = updateTransaction($transactionData);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while updating the transaction. Please try again.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
    exit();
}
