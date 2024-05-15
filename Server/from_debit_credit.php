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
        // Tipo non valido, reindirizza con errore
        header("Location: ../Client/index.php?error=invalid_type");
        exit();
    }

    // Esegui l'aggiornamento della data di estinzione
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $today, $id);
        $stmt->execute();
        $stmt->close();

        // Prepara la chiamata alla stored procedure
        if ($type == 'debit') {
            $sp_query = "CALL create_transaction_on_debit_termination(?)";
        } else if ($type == 'credit') {
            $sp_query = "CALL create_transaction_on_credit_termination(?)";
        }

        // Esegui la stored procedure per creare la transazione
        if ($sp_stmt = $conn->prepare($sp_query)) {
            $sp_stmt->bind_param("i", $id);
            $sp_stmt->execute();
            $sp_stmt->close();
        } else {
            // Errore nella preparazione della stored procedure
            header("Location: ../Client/index.php?error=sp_preparation_failed");
            exit();
        }
    } else {
        // Errore nella preparazione della query di aggiornamento
        header("Location: ../Client/index.php?error=query_preparation_failed");
        exit();
    }
    $conn->close();
} else {
    // Parametri mancanti, reindirizza con errore
    header("Location: ../Client/index.php?error=missing_parameters");
    exit();
}

// Reindirizza alla pagina desiderata dopo l'operazione
header("Location: ../Client/index.php?success=termination_complete");
exit();
