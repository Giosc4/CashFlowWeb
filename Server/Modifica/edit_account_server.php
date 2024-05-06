<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/write_functions.php';

// Verifica se la richiesta è di tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se i parametri sono stati inviati correttamente
    if (isset($_POST["accountId"]) && isset($_POST["accountName"]) && isset($_POST["accountBalance"])) {
        // Recupera i valori inviati dal form
        $accountId = $_POST['accountId'];
        $accountName = $_POST['accountName'];
        $accountBalance = $_POST['accountBalance'];

        // Aggiorna l'account nel database
        if (updateAccount($accountId, $accountName, $accountBalance)) {
            // Se l'aggiornamento è riuscito, reindirizza alla pagina principale del cliente
            header("Location: ../../client/index.php");
            exit();
        } else {
            // Se c'è stato un errore nell'aggiornamento, mostra un messaggio di errore
            echo "Errore nell'aggiornamento dell'account.";
            exit();
        }
    } else {
        // Se i parametri non sono stati inviati correttamente, mostra un messaggio di errore
        echo "Parametri mancanti.";
        exit();
    }
} else {
    // Se la richiesta non è di tipo POST, reindirizza alla pagina principale del cliente
    header("Location: ../../client/index.php");
    exit();
}
?>
