<?php
require_once '../db/db_connection.php';

if (isset($_GET['debitCredit_ID']) && isset($_GET['type'])) {
    $id = $_GET['debitCredit_ID'];
    $type = $_GET['type'];
    $today = date("Y-m-d");

    if ($type == 'debit') {
        $query = "UPDATE debit SET DataEstinsione = ? WHERE ID = ?";
    } else if ($type == 'credit') {
        $query = "UPDATE credit SET DataEstinsione = ? WHERE ID = ?";
    } else {
        // Invalid type, redirect with error
        header("Location: ../Client/index.php?error=invalid_type");
        exit();
    }

    // Execute the update query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $today, $id);
        $stmt->execute();
        $stmt->close();

        // Reopen a new connection for the stored procedure
        $conn->close();
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Execute the stored procedure
        if ($type == 'debit') {
            $sp_query = "CALL create_transaction_on_debit_termination(?)";
        } else if ($type == 'credit') {
            $sp_query = "CALL create_transaction_on_credit_termination(?)";
        }

        if ($sp_stmt = $conn->prepare($sp_query)) {
            $sp_stmt->bind_param("i", $id);
            $sp_stmt->execute();
            $sp_stmt->close();
        } else {
            // Error in stored procedure preparation
            header("Location: ../Client/index.php?error=sp_preparation_failed");
            exit();
        }

        $conn->close(); // Close the connection
    } else {
        // Error in query preparation
        header("Location: ../Client/index.php?error=query_preparation_failed");
        exit();
    }
} else {
    // Missing parameters, redirect with error
    header("Location: ../Client/index.php?error=missing_parameters");
    exit();
}

// Redirect to the desired page after operation
header("Location: ../Client/index.php?success=termination_complete");
exit();
?>
