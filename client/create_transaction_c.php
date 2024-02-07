<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Transazione</title>
</head>

<?php
require_once '../db/read_db.php';
$accounts = getAllAccounts();
$categoriePrimarie = getAllCategoriePrimarie();
$categorieSecondarie = getAllCategorieSecondarie();
?>

<body>
    <h2>Crea una nuova transazione</h2>
    <form action="../server/create_transaction_s.php" method="post">
        <label for="isEntrata">Transazione di Entrata:</label>
        <input type="checkbox" name="isEntrata" id="isEntrata" value="1"><br><br>

        <label for="importo">Importo:</label>
        <input type="number" step="0.01" name="importo" id="importo" required><br><br>

        <label for="idAccount">ID Account:</label>
        <select name="idAccount" id="idAccount" required>
            <?php
            foreach ($accounts as $account) {
                echo "<option value='{$account['IdAccount']}'>{$account['Nome_Account']}</option>";
            }
            ?>
        </select><br><br>

        <label for="dataTransazione">Data Transazione:</label>
        <input type="date" name="dataTransazione" id="dataTransazione" value="<?= date('Y-m-d'); ?>" required><br><br>

        <label for="idCategoriaPrimaria">ID Categoria Primaria:</label>
        <select name="idCategoriaPrimaria" id="idCategoriaPrimaria">
            <?php
            foreach ($categoriePrimarie as $categoria) {
                echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
            }
            ?>
        </select><br><br>

        <label for="idCategoriaSecondaria">ID Categoria Secondaria:</label>
        <select name="idCategoriaSecondaria" id="idCategoriaSecondaria">
            <option value="" selected>Seleziona una categoria secondaria</option>

            <?php
            // Inizialmente, visualizza tutte le categorie secondarie
            foreach ($categorieSecondarie as $categoria) {
                echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
            }
            ?>
        </select><br><br>

        <label for="descrizione">Descrizione:</label>
        <textarea name="descrizione" id="descrizione"></textarea><br><br>

        <input type="submit" value="Crea Transazione">
    </form>

    <br>
    <a href="../client/index.php"><button>Ritorna ad Index</button></a>
</body>

</html>
