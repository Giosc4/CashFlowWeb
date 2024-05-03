<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Home Page</h1>
    <ol>
        <li><a href="new_transaction_client.php">Creazione Transazione</a></li>
        <li><a href="new_conto_client.php">Creazione Conto</a></li>
        <li><a href="new_categoria_primaria_client.php">Creazione Categoria Primaria</a></li>
        <li><a href="new_categoria_secondaria_client.php">Creazione Categoria Secondaria</a></li>
        <li><a href="new_profile_client.php">Creazione Profilo</a></li>
        <li><a href="new_template_transaction_client.php"> Creazione Template Transazione</a></li>
        <li><a href="new_risparmio_client.php">Creazione di un Risparmio</a></li>
        <li><a href="new_debit_client.php">Creazione di un Debito</a></li>
        <li><a href="new_credit_client.php">Creazione di un Credito</a></li>
        <li><a href="new_budget_client.php">Creazione di un Budget</a></li>
        <li><a href="new_obiettivo_client.php">Creazione di un Obiettivo</a></li>

         <a href="../server/logout.php">Logout</a> 
    </ol>

    <h2>Contenuto delle tabelle</h2>
    <?php
    require_once '../server/other_functions.php';
    displayAllTables(); ?>

</body>

</html>