<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Crea Categoria Secondaria</title>
</head>

<body>
    <h2>Crea una nuova Categoria Secondaria</h2>
    <form action="../server/create_secondary_category_s.php" method="post">
        <label for="idCategoriaPrimaria">Categoria Primaria:</label>
        <select name="idCategoriaPrimaria" id="idCategoriaPrimaria" required>
            <?php
            require_once '../db/read_db.php';
            $categoriePrimarie = getAllCategoriePrimarie();
            foreach ($categoriePrimarie as $categoria) {
                echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
            }
            ?>
        </select><br><br>

        <label for="nomeCategoria">Nome Categoria:</label>
        <input type="text" name="nomeCategoria" id="nomeCategoria" required><br><br>

        <label for="descrizioneCategoria">Descrizione:</label>
        <textarea name="descrizioneCategoria" id="descrizioneCategoria"></textarea><br><br>

        <input type="submit" value="Crea Categoria">
    </form>
    <br>
    <a href="../client/index.php"><button>Ritorna ad Index</button></a>
</body>

</html>