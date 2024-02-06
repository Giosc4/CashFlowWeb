<?php
require_once '../db/db.php'; 
require_once '../db/write_db.php';

// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeAccount = $_POST['nomeAccount'];
    $saldo = $_POST['saldo'];
    // Aggiungi altri campi qui

    // Convalida i dati (esempio molto semplice)
    if (empty($nomeAccount) || empty($saldo)) {
        die('I campi Nome Account e Saldo sono obbligatori.');
    } else if (!is_numeric($saldo)) {
        die('Il saldo deve essere un numero.');
    } else {
        createAccount($nomeAccount, $saldo);
        header('Location: ../client/index.php');
        exit();
    }

    // Chiudi la connessione
    $conn->close();
}
?>
