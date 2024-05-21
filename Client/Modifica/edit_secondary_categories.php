<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';

// Ottieni l'ID della categoria secondaria dalla query parameters
$categoryId = $_GET['id'] ?? null;

// Recupera i dettagli della categoria secondaria dal database usando l'ID della categoria
$category = getSecondaryCategoryFromID($categoryId);

// Check se la categoria esiste
if (!$category) {
    echo "Secondary Category not found 1.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}

global $selectCategoriaPrimariaFromEmail;
$primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Categoria Secondaria</title>
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
        select {
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

    <h1>Modifica Categoria Secondaria</h1>
    <?php if ($category) : ?>
        <form action="../../server/modifica/edit_secondary_category_server.php" method="POST">
            <!-- Campo nascosto per inviare l'ID della categoria -->
            <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($category['ID']); ?>">

            <!-- Campo per visualizzare il nome della categoria secondaria -->
            <div>
                <label for="categoryName">Nome Categoria:</label>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['NomeCategoria']); ?>" required autocomplete="off">
            </div>

            <!-- Campo per selezionare la categoria primaria -->
            <div>
                <label for="primaryCategoryId">Categoria Primaria:</label>
                <select id="primaryCategoryId" name="primaryCategoryId" required>
                    <option value="" disabled>Seleziona la Categoria Primaria</option>
                    <?php foreach ($primaryCategories as $primaryCategory) : ?>
                        <option value="<?php echo htmlspecialchars($primaryCategory['ID']); ?>" <?php if ($primaryCategory['ID'] == $category['IDCategoriaPrimaria']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($primaryCategory['NomeCategoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campo per visualizzare la descrizione della categoria secondaria -->
            <div>
                <label for="categoryDescription">Descrizione Categoria:</label>
                <input type="text" id="categoryDescription" name="categoryDescription" value="<?php echo htmlspecialchars($category['DescrizioneCategoria']); ?>" autocomplete="off">
            </div>

            <!-- Pulsante per inviare le modifiche -->
            <input type="submit" value="Salva Modifiche">
        </form>

        <!-- Form per eliminare la categoria -->
        <form action="../../server/eliminazione/delete_secondary_category.php" method="POST">
            <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($category['ID']); ?>">
            <button type="submit" class="delete-button">Cancella Categoria</button>
        </form>

    <?php else : ?>
        <p>Secondary Category not found 2.</p>
    <?php endif; ?> <br> <br> <?php require('../footer.php') ?>

</body>

</html>