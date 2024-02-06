<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crea Account</title>
</head>
<body>
    <h2>Crea un nuovo account</h2>
    <form action="../server/create_account_s.php" method="post">
        <label for="nomeAccount">Nome Account:</label><br>
        <input type="text" id="nomeAccount" name="nomeAccount" required><br>

        <label for="saldo">Saldo:</label><br>
        <input type="text" id="saldo" name="saldo" required><br>

        <!-- Aggiungi altri campi qui se necessario -->

        <input type="submit" value="Crea Account">
    </form>
</body>
</html>
