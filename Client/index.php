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
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

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

        h1,
        h2,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background-color: red;
            color: white;
        }

        .btn-create {
            background-color: green;
            color: white;
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
    <br> <br> <?php require('footer.php') ?>

</body>

</html>