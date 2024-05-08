<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: /CashFlowWeb/client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Budget</title>
</head>

<body>
    <form action="/CashFlowWeb/server/creazione/new_budget_server.php" method="post">

        <label for="budgetName">Nome Budget:</label>
        <input type="text" id="budgetName" name="budgetName" required><br>

        <label for="amount">Valore:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="budgetStartDate">Data Inizio Budget:</label>
        <input type="date" id="budgetStartDate" name="budgetStartDate" value="<?php echo date("Y-m-d"); ?>" required><br>
        <label for="budgetEndDate">Data Inizio Budget:</label>
        <input type="date" id="budgetEndDate" name="budgetEndDate" value="<?php echo date("Y-m-d"); ?>" required><br>
        <label for="primaryCategory">Categoria Primaria:</label>


        <?php
        require_once '../../db/read_functions.php';
        global  $selectCategoriaPrimariaFromEmail;
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);   
        ?>

        <!-- Primary Category Selection -->
        <label for="primaryCategoryId">Select a Primary Category:</label>
        <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
            <option value="" disabled selected>Please select a Primary Category</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Crea Categoria">

    </form>
</body>

</html>