<?php
session_start();
require_once '../db/delete_functions.php';
require_once '../db/update_functions.php';
require_once '../db/fromID_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../db/write_functions.php';
require_once '../server/other_functions.php';

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ./log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php require('navbar.php') ?>

    <h1>Home Page</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <div class="container">
        <h2>Contenuto delle tabelle</h2>
        <?php
        displayAllTables();
        ?>
    </div>
</body>

</html>