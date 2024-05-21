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
    <title>Creazione Categoria Secondaria</title>
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
    <form action="../../Server/creazione/new_categoria_secondaria_server.php" method="post">
        <h1>Crea Categoria Secondaria</h1>

        <label for="categoryName">Nome della Categoria Secondaria:</label>
        <input type="text" id="categoryName" name="categoryName" required autocomplete="off"><br>

        <label for="categoryId">Seleziona una Categoria Primaria:</label>
        <?php
        require_once '../../db/read_functions.php';
        global  $selectCategoriaPrimariaFromEmail;
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>
        <select name="categoryId" required>
            <option value="" disabled selected>Per favore seleziona una Categoria</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoryDescription">Descrizione Categoria:</label>
        <input type="text" id="categoryDescription" name="categoryDescription" autocomplete="off"><br>

        <input type="submit" value="Crea Categoria">
    </form>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>