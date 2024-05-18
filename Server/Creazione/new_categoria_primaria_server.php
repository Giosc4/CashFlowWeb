<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["categoryName"]) && isset($_POST["categoryDescription"])) {
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'];
        $profiloID = getIDProfiloByEmail($_SESSION['email']);

        $IDCategory = createPrimaryCategory($categoryName, $categoryDescription, $profiloID);
        if ($IDCategory !== false) {
            header("Location: ../../client/index.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to create primary category: $categoryName";
            header("Location: ../../client/log_in_profile_client.php");
            exit();
        }
    }
}
