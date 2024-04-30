<?php
require_once '../db/write_functions.php';
require_once '../db/read_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["categoryId"]) && isset($_POST["categoryName"]) && isset($_POST["categoryDescription"])) {
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'] ?? '';

        createSecondaryCategory($categoryId, $categoryName, $categoryDescription);
        header("Location: ../client/index.php");
        exit();
    } else {
        echo "Errore: Assicurati di compilare tutti i campi obbligatori.";
    }
}
?>
