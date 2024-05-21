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
    <title>Creazione Template Transazione</title>
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
        select,
        textarea {
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Creazione Template Transazione</h1>
    <form action="/CashFlowWeb/server/creazione/new_template_transaction_server.php" method="post">

        <label for="templateName">Nome del Template:</label>
        <input type="text" id="templateName" name="templateName" required><br>

        <label for="isExpense">è una spesa:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br>

        <?php
        require_once '../../db/read_functions.php';
        global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail, $selectCategoriaSecondariaFromEmail;
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
        <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
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
    </script>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>
