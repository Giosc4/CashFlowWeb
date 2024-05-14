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
    </style>
</head>

<body>
    <h1>Home Page</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']); 
    }
    ?>
    <div>
        <h3>Creazione</h3>
        <ol>
            <li><a href="/CashFlowWeb/Client/Creazione/new_transaction_client.php">Creazione Transazione</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_conto_client.php">Creazione Conto</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_categoria_primaria_client.php">Creazione Categoria Primaria</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_categoria_secondaria_client.php">Creazione Categoria Secondaria</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_template_transaction_client.php"> Creazione Template Transazione</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_risparmio_client.php">Creazione di un Risparmio</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_debit_client.php">Creazione di un Debito</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_credit_client.php">Creazione di un Credito</a></li>
            <li><a href="/CashFlowWeb/Client/Creazione/new_budget_client.php">Creazione di un Budget</a></li>
        </ol>
    </div>

    <a href="/CashFlowWeb/server/logout.php">Logout</a>

    <h2>Contenuto delle tabelle</h2>
    <?php
    displayAllTables();
    ?>
</body>

</html>