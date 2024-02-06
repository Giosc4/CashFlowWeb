<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Home Page</h1>
    <ul>
        <li><a href="../client/create_transaction_c.php">Creazione Transazione</a></li>
        <li><a href="../client/create_account_c.php">Creazione Account</a></li>
        <li><a href="../client/create_primary_category_c.php">Creazione Categoria Primaria</a></li>
        <li><a href="../client/create_secondary_category_c.php">Creazione Categoria Secondaria</a></li>

    </ul>

    <h2>Contenuto delle tabelle</h2>
    <?php
    require_once '../server/functions.php';
    displayAllTables(); ?>
</body>

</html>