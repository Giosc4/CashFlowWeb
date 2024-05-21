<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


// Get transaction ID from query parameters
$id = $_GET['id'] ?? null;

// Fetch the transaction details from the database using the transaction ID
$transaction = $id ? getTransactionFromID($id) : null;

global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail, $selectCategoriaSecondariaFromEmail;
$accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
$primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
$secondaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaSecondariaFromEmail);

// Check if transaction exists
if (!$transaction) {
    echo "Transaction not found.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
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
            margin-top: 20px;
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

        input[type="submit"],
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: red;
        }

        .delete-button:hover {
            background-color: darkred;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php'; ?> <br><br>

    <h1>Edit Transaction</h1>
    <?php if ($transaction) : ?>
        <form action="../../server/modifica/edit_transaction_server.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID']); ?>"><br>

            <label for="isExpense">è una spesa:</label>
            <input type="checkbox" id="isExpense" name="isExpense" <?php echo ($transaction['Is_Expense'] ? 'checked' : ''); ?>><br>

            <label for="amount">Importo:</label>
            <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($transaction['Importo']); ?>" step="0.01" required><br>

            <label for="date">Transaction Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($transaction['DataTransazione']); ?>" required><br>

            <label for="accountId">Seleziona un Conto:</label>
            <select id="accountId" name="accountId" required>
                <option value="" disabled selected>Seleziona un Conto</option>
                <?php foreach ($accounts as $account) : ?>
                    <option value="<?php echo $account['ID']; ?>"><?php echo $account['NomeConto']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="primaryCategoryId">Seleziona una Categoria Primaria:</label>
            <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
                <option value="" disabled>Seleziona una Categoria Primaria</option>
                <?php foreach ($primaryCategories as $category) : ?>
                    <option value="<?php echo $category['ID']; ?>" <?php echo ($category['ID'] == $transaction['IDCategoriaPrimaria']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['NomeCategoria']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="secondaryCategoryId">Seleziona una Categoria Secondaria:</label>
            <select id="secondaryCategoryId" name="secondaryCategoryId">
                <option value="" disabled>Seleziona una Categoria Secondaria</option>
                <?php foreach ($secondaryCategories as $category) : ?>
                    <option value="<?php echo $category['ID']; ?>" data-primary-id="<?php echo $category['IDCategoriaPrimaria']; ?>" <?php echo ($category['ID'] == $transaction['IDCategoriaSecondaria']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['NomeCategoria']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <button type="submit" class="save">Save Changes</button><br>
        </form>

        <form action="../../server/eliminazione/delete_transaction.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID']); ?>">
            <button type="submit" class="delete-button">Delete Transaction</button>
        </form>
    <?php else : ?>
        <p>Transaction not found.</p>
    <?php endif; ?>

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
                    var selectedSecondaryCategoryId = "<?php echo $transaction['IDCategoriaSecondaria']; ?>";
                    $secondarySelect.empty();
                    $secondarySelect.append('<option disabled selected>Per favore Seleziona la Categoria Secondaria</option>');
                    categories.forEach(function(category) {
                        var $option = $('<option>', {
                            value: category.ID,
                            text: category.NomeCategoria
                        });
                        if (category.ID == selectedSecondaryCategoryId) {
                            $option.attr('selected', 'selected');
                        }
                        $secondarySelect.append($option);
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            updateSecondaryCategories();
        });
    </script>
    <br> <br> <?php require('../footer.php') ?>

</body>

</html>