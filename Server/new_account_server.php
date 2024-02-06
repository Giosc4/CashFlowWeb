<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accountName']) && !empty($_POST['accountName'])) {
        $accountName = $_POST['accountName']; // This line was missing in the original code to actually get the accountName from the POST data.
        if (!empty($accountName)) {
            createAccount($accountName);
            echo "Account creato con successo.";
            header("Location: ../client/index.php");
            exit(); // It's a good practice to call exit() after sending a Location header.
        } else {
            echo "Errore: Il nome dell'account non può essere vuoto.";
        }
    }
}
?>
