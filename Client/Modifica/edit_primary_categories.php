<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';

// Ottieni l'ID della categoria primaria dalla query parameters
$categoryId = $_GET['id'] ?? null;

// Recupera i dettagli della categoria primaria dal database usando l'ID della categoria
$category = $categoryId ? getPrimaryCategoryById($categoryId) : null;

// Check se la categoria esiste
if (!$category) {
    echo "Categoria non trovata.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Categoria Primaria</title>
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

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: red;
        }

        .delete-button:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php'; ?> <br><br>

    <h1>Modifica Categoria Primaria</h1>
    <?php if ($category) : ?>
        <form action="../../Server/modifica/edit_categoria_primaria_server.php" method="POST">
            <!-- Campo nascosto per inviare l'ID della categoria -->
            <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($category['ID']); ?>">

            <!-- Campo per visualizzare il nome della categoria primaria -->
            <div>
                <label for="categoryName">Nome Categoria Primaria:</label>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['NomeCategoria']); ?>" required autocomplete="off">
            </div>

            <!-- Campo per visualizzare la descrizione della categoria primaria -->
            <div>
                <label for="categoryDescription">Descrizione Categoria Primaria:</label>
                <textarea id="categoryDescription" name="categoryDescription"><?php echo htmlspecialchars($category['DescrizioneCategoria']); ?></textarea>
            </div>

            <!-- Pulsante per inviare le modifiche -->
            <input type="submit" value="Modifica Categoria">
        </form>

        <!-- Form to delete the transaction -->
        <form action="../../server/eliminazione/delete_primary_category.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['ID']); ?>">
            <button type="submit" class="delete-button">Cancella Categoria Primaria</button>
        </form>

    <?php else : ?>
        <p>Categoria non trovata.</p>
    <?php endif; ?>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>