<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Risparmio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
               
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <form action="/CashFlowWeb/server/creazione/new_risparmio_server.php" method="post">
        <h1>Crea Risparmio</h1>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="risparmioDateInizio">Data Inizio Risparmio:</label>
        <input type="date" id="risparmioDateInizio" name="risparmioDateInizio" value="<?php echo date("Y-m-d"); ?>" required><br>

        <label for="risparmioDateFine">Data Fine Risparmio:</label>
        <input type="date" id="risparmioDateFine" name="risparmioDateFine" value="<?php echo date("Y-m-d", strtotime("+1 day")); ?>" required><br>

        <?php
        require_once '../../db/read_functions.php';
        global $selectContoFromEmail;
        $conti = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>

        <label for="contoId">Seleziona un Conto:</label>
        <select name="contoId" required>
            <option value="" disabled selected>Per favore seleziona un Conto</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['ID']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="primaryCategoryId">Seleziona una Categoria Primaria:</label>
        <select id="primaryCategoryId" name="primaryCategoryId" required>
            <option value="" disabled selected>Seleziona una Categoria Primaria</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Crea Risparmio">
    </form>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>