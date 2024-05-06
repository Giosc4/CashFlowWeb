<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Template Transazione</title>
</head>

<body>
    <h1>Creazione Template Transazione</h1>
    <form action="/CashFlowWeb/server/creazione/new_template_transaction_server.php" method="post">

        <label for="templateName">Nome del Template:</label>
        <input type="text" id="templateName" name="templateName" required><br>

        <label for="isExpense">Is Expense:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br>

        <?php
        require '../../db/read_functions.php';
        global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail;
        $accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        $secondaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaSecondariaFromEmail);
        ?>

        <label for="accountId">Seleziona un Conto:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled selected>Seleziona un Conto</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['ID']; ?>"><?php echo $account['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="primaryCategoryId">Seleziona una Categoria Primaria:</label>
        <select id="primaryCategoryId" name="primaryCategoryId" required>
            <option value="" disabled selected>Seleziona una Categoria Primaria</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="secondaryCategoryId">Seleziona una Categoria Secondaria:</label>
        <select id="secondaryCategoryId" name="secondaryCategoryId">
            <option value="" disabled selected>Seleziona una Categoria Secondaria</option>
            <?php foreach ($secondaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="description">Descrizione:</label>
        <textarea id="description" name="description"></textarea><br>

        <input type="submit" value="Crea Transazione">
    </form>

</body>

</html>