<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: /client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Credito</title>
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
        }
    </style>
</head>

<body>
    <?php require('../navbar.php') ?> <br> <br>
    <form action="../../server/creazione/new_credit_server.php" method="post">
        <h1>Nuovo Credito</h1>

        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" required autocomplete="off"><br>

        <label for="amount">Valore:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="creditConcessioneDate">Data Concessione Credito:</label>
        <input type="date" id="creditConcessioneDate" name="creditConcessioneDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <label for="creditEstinsioneDate">Data Estinsione Credito:</label>
        <input type="date" id="creditEstinsioneDate" name="creditEstinsioneDate" value="<?php echo date("Y-m-d"); ?>"><br>

        <label for="contoId">Seleziona un Conto:</label>
        <?php
        require_once '../../db/read_functions.php';
        global $selectContoFromEmail;
        $conti = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        ?>
        <select name="contoId" required>
            <option value="" disabled selected>Per favore seleziona un Conto</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['ID']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoriaPrimaria">Seleziona Categoria Primaria:</label>
        <?php
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>
        <select name="categoriaPrimariaId" required>
            <option value="" disabled selected>Seleziona una Categoria</option>
            <?php foreach ($primaryCategories as $categoria) : ?>
                <option value="<?php echo $categoria['ID']; ?>"><?php echo $categoria['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="description">Descrizione:</label>
        <input type="text" id="description" name="description"><br>

        <input type="submit" value="Crea Credito">
    </form>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>
