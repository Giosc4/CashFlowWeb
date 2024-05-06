<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria Primaria</title>
</head>

<body>
    <form action="../../Server/creazione/new_categoria_primaria_server.php" method="POST">
        <label for="categoryName">Nome della Categoria Primaria:</label><br>
        <input type="text" id="categoryName" name="categoryName" required autocomplete="off"><br>

        <label for="categoryDescription">Descrizione della Categoria:</label><br>
        <textarea id="categoryDescription" name="categoryDescription"></textarea><br>

        <label for="categoryBudget">Budget della Categoria (opzionale):</label><br>
        <?php
        include '../../db/read_functions.php';
        global $selectBudgetFromEmail;
        $budgets = getTableBYEmail($_SESSION['email'], $selectBudgetFromEmail);
        ?>
        <select name="budgetId">
            <option value="" selected>Scegli un Budget (opzionale)</option>
            <?php foreach ($budgets as $budget) : ?>
                <option value="<?php echo $budget['IDBudget']; ?>"><?php echo $budget['NomeBudget']; ?></option>
            <?php endforeach; ?>
        </select><br>


        <input type="submit" value="Crea Categoria">
    </form>
</body>

</html>