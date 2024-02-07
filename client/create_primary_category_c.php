<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Categoria Primaria</title>
</head>

<body>
    <h2>Aggiungi una nuova Categoria Primaria</h2>
    <form action="../server/create_primary_category_s.php" method="post">
        <label for="nomeCategoria">Nome Categoria:</label>
        <input type="text" name="nomeCategoria" id="nomeCategoria" required><br><br>

        <label for="descrizioneCategoria">Descrizione Categoria:</label>
        <textarea name="descrizioneCategoria" id="descrizioneCategoria"></textarea><br><br>

        <label for="idBudgetMassimo">ID Budget Massimo (opzionale):</label>
        <input type="number" name="idBudgetMassimo" id="idBudgetMassimo"><br><br>

        <input type="submit" value="Aggiungi Categoria">
    </form>

    <br>
    <a href="../client/index.php"><button>Ritorna ad Index</button></a>
</body>

</html>