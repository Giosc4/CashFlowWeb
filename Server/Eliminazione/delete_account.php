<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/write_functions.php';

// Verifica se il metodo della richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera e sanifica l'ID dell'account
    $accountId = $_POST['id'] ?? null;

    // Valida i campi obbligatori
    if (!$accountId) {
        echo "ID dell'account mancante.";
        exit();
    }

    // Tentativo di eliminare l'account
    $result = deleteAccount($accountId);

    if ($result) {
        // Se l'eliminazione ha successo, reindirizza alla pagina principale
        header("Location: ../../client/index.php");
        exit();
    } else {
        // Se si verifica un errore durante l'eliminazione, visualizza un messaggio di errore
        echo "Si è verificato un errore durante l'eliminazione dell'account. Riprova.";
    }
} else {
    // Se il metodo della richiesta non è POST, mostra un messaggio di errore
    echo "Metodo di richiesta non valido.";
    exit();
}
?>
