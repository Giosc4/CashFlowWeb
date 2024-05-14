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

$templateId = $_POST['id'] ?? null; // Recupera l'ID del template di transazione dalla richiesta POST

if (!$templateId) {
    echo "Nessun template specificato.";
    exit();
}

if (deleteTemplateTransaction($templateId)) {
    header("Location: ../../client/index.php");
} else {
    echo "Si è verificato un errore durante l'eliminazione del template transazione.";
}
