<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Home Page</h1>
    <ul>
        <li><a href="new_transaction_client.php">Creazione Transazione</a></li>
        <li><a href="new_account_client.php">Creazione Account</a></li>
        <li><a href="new_category_client.php">Creazione Categoria</a></li>
    </ul>

    <h2>Contenuto delle tabelle</h2>
    <?php
    require_once '../server/other_functions.php';
    displayAllTables(); ?>

</body>

</html>