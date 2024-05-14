<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transactionID = $_POST['id'] ?? null;

    if (!$transactionID) {
        echo "Transaction ID is missing.";
        exit();
    }

    $result = deleteTransaction($transactionID);

    if ($result) {
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "An error occurred while deleting the transaction. Per favore try again.";
    }
} else {
    echo "Invalid request method.";
    exit();
}
