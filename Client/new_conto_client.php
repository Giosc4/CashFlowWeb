<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="new_conto_server.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="saldo">Saldo:</label>
        <input type="number" name="saldo" id="saldo" required><br>

        <input type="submit" value="Create Conto">
    </form>
</body>

</html>