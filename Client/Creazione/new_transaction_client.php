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
    <title>Creazione Transazione</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <h1>Creazione Transazione</h1>
    <form action="../../server/creazione/new_transaction_server.php" method="post">
        <label for="isExpense">è una spesa:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <?php
        require_once '../../db/read_functions.php';
        global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail;
        $accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>

        <label for="accountId">Seleziona un Conto:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled selected>Per favore select the Account</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['ID']; ?>"><?php echo $account['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="primaryCategoryId">Seleziona la Categoria Primaria:</label>
        <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
            <option value="" disabled selected>Seleziona la Categoria Primaria</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="secondaryCategoryId">Seleziona la Categoria Secondaria:</label>
        <select id="secondaryCategoryId" name="secondaryCategoryId">
            <option value="" disabled selected>Per favore Seleziona la Categoria Secondaria</option>
        </select><br>

        <label for="transactionDate">Transaction Date:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Transazione">
    </form>

    <script>
        function updateSecondaryCategories() {
            var primaryCategoryId = $('#primaryCategoryId').val();

            $.ajax({
                url: '../server/get_secondary_categories.php',
                type: 'GET',
                data: {
                    primaryCategoryId: primaryCategoryId
                },
                dataType: 'json',
                success: function(categories) {
                    var $secondarySelect = $('#secondaryCategoryId');
                    $secondarySelect.empty();
                    $secondarySelect.append('<option disabled selected>Per favore Seleziona la Categoria Secondaria</option>');
                    categories.forEach(function(category) {
                        $secondarySelect.append($('<option>', {
                            value: category.ID,
                            text: category.NomeCategoria
                        }));
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>