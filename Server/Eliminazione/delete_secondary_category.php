<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/write_functions.php';

// Verifica se è stato inviato l'ID della categoria secondaria da eliminare
if (isset($_POST['categoryId'])) {
    // Ottieni l'ID della categoria secondaria da eliminare
    $categoryId = $_POST['categoryId'];

    // Elimina la categoria secondaria
    if (deleteSecondaryCategory($categoryId)) {
        // Se la cancellazione è avvenuta con successo, reindirizza alla pagina delle categorie
        header("Location: ../../client/");
        exit();
    } else {
        // Se si è verificato un errore durante l'eliminazione, mostra un messaggio di errore
        echo "Error deleting secondary category.";
        exit();
    }
} else {
    // Se l'ID della categoria non è stato ricevuto, mostra un messaggio di errore
    echo "Category ID not provided.";
    exit();
}
?>
