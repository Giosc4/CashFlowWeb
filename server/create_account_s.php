<?php
require_once '../db/db.php'; 
require_once '../db/write_db.php';

// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeAccount = $_POST['nomeAccount'];
    $saldo = $_POST['saldo'];

    // Convalida i dati (esempio molto semplice)
    if (empty($nomeAccount)) {
        die('Il Nome Account è obbligatorio.');
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
