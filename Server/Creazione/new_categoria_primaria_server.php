<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}

require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/write_functions.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/queries.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/read_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["categoryName"]) && isset($_POST["categoryDescription"])) {
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'];

        $IDCategory = createPrimaryCategory($categoryName, $categoryDescription);
        if ($IDCategory !== false) {
            $profiloID = getIDProfiloByEmail($_SESSION['email']);

            // Ensure profilID is not false before proceeding
            if ($profiloID !== false && $profiloID !== null) {
                associateProfileToCategory($profiloID, $IDCategory);
                header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/index.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to retrieve profile ID for email: " . $_SESSION['email'];
                header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Failed to create primary category: $categoryName";
            header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
            exit();
        }
    }
}
