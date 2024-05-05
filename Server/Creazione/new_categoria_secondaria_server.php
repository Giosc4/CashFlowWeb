<?php
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/write_functions.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/read_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["categoryId"]) && isset($_POST["categoryName"]) && isset($_POST["categoryDescription"])) {
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'] ?? '';

        createSecondaryCategory($categoryId, $categoryName, $categoryDescription);
        header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/index.php");
        exit();
    } else {
        echo "Errore: Assicurati di compilare tutti i campi obbligatori.";
    }
}
?>
