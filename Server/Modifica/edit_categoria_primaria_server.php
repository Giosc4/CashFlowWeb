<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/write_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["categoryId"]) && isset($_POST["categoryName"]) && isset($_POST["categoryDescription"])) {
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'];

        if (updatePrimaryCategory($categoryId, $categoryName, $categoryDescription)) {
            header("Location: ../../client/index.php");
            exit();
        }
    }
}
