<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Transazione</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php require('../navbar.php') ?> <br> <br>
    <h1>Creazione Transazione</h1>
    <form action="../../server/creazione/new_transaction_server.php" method="post">
        <label for="isExpense">è una spesa:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <?php
        require_once '../../db/read_functions.php';
        global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail, $selectCategoriaSecondariaFromEmail;
        $accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>

        <label for="accountId">Seleziona un Conto:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled selected>Per favore seleziona un Conto</option>
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
            <option value="" disabled selected>Per favore seleziona la Categoria Secondaria</option>
        </select><br>

        <label for="transactionDate">Data della Transazione:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Transazione">
    </form>

    <script>
        function updateSecondaryCategories() {
            var primaryCategoryId = $('#primaryCategoryId').val();

            $.ajax({
                url: '../../server/get_secondary_categories.php',
                type: 'GET',
                data: {
                    primaryCategoryId: primaryCategoryId
                },
                dataType: 'json',
                success: function(categories) {
                    var $secondarySelect = $('#secondaryCategoryId');
                    $secondarySelect.empty();
                    $secondarySelect.append('<option disabled selected>Per favore seleziona la Categoria Secondaria</option>');
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
    </script>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>