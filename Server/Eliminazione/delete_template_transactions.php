<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/write_functions.php'; 
$templateId = $_POST['id'] ?? null; // Recupera l'ID del template di transazione dalla richiesta POST

if (!$templateId) {
    echo "Nessun template specificato.";
    exit();
}

// Elimina il template di transazione dal database
if (deleteTemplateTransaction($templateId)) {
    header("Location: ../../client/index.php"); 
} else {
    echo "Si è verificato un errore durante l'eliminazione del template transazione.";
}
?>
