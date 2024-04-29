<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['categoryName']) && !empty($_POST['categoryName'])) {
        $categoryName = $_POST['categoryName']; // Getting the categoryName from POST data.
        if (!empty($categoryName)) {
            createCategory($categoryName);
            echo "Categoria creata con successo.";
            header("Location: ../client/index.php");
            exit(); // Exit after redirection.
        } else {
            echo "Errore: Il nome della categoria non può essere vuoto.";
        }
    }
}
?>
