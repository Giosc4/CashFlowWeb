<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
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
    <form action="../server/new_template_transaction_server.php" method="post">

        <label for="templateName">Nome del Template:</label>
        <input type="text" id="templateName" name="templateName" required><br>

        <label for="entryType">Tipo di Transazione (Entrata/Uscita):</label>
        <select id="entryType" name="entryType" required>
            <option value="" disabled selected>Seleziona Tipo</option>
            <option value="Entrata">Entrata</option>
            <option value="Uscita">Uscita</option>
        </select><br>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br>

        <?php
        require_once '../server/other_functions.php';
        $accounts = getAllConti();
        $primaryCategories = getAllPrimaryCategories();
        $secondaryCategories = getAllSecondaryCategories();
        ?>

        <label for="accountId">Seleziona un Conto:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled selected>Seleziona un Conto</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['IDConto']; ?>"><?php echo $account['NomeConto']; ?></option>
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