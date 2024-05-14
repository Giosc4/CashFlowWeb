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
</head>

<body>
    <h1>Edit Transaction</h1>
    <?php if ($transaction) : ?>
        <form action="../../server/modifica/edit_transaction_server.php" method="post">
            <!-- Hidden field to send the transaction ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID']); ?>">

            <!-- Field to edit whether the transaction is an expense -->
            <div>
                <label for="isExpense">è una spesa:</label>
                <input type="checkbox" id="isExpense" name="isExpense" <?php echo ($transaction['Is_Expense'] ? 'checked' : ''); ?>><br>
            </div>

            <!-- Field to edit the transaction amount -->
            <div>
                <label for="amount">Importo:</label>
                <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($transaction['Importo']); ?>" step="0.01" required>
            </div>

            <!-- Field to edit the transaction date -->
            <div>
                <label for="date">Transaction Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($transaction['DataTransazione']); ?>" required>
            </div>
            <!-- Account Selection -->
            <div>
                <label for="accountId">Seleziona un Conto:</label>
                <select id="accountId" name="accountId" required>
                    <?php foreach ($accounts as $account) : ?>
                        <option value="<?php echo htmlspecialchars($account['ID']); ?>" <?php if ($account['ID'] == $transaction['IDConto']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($account['NomeConto']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <!-- Primary Category Selection -->
            <div>
                <label for="primaryCategoryId">Seleziona la Categoria Primaria:</label>
                <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
                    <option value="" disabled <?php if (!$transaction['IDCategoriaPrimaria']) echo 'selected'; ?>>Seleziona la Categoria Primaria</option>
                    <?php foreach ($primaryCategories as $category) : ?>
                        <option value="<?php echo htmlspecialchars($category['ID']); ?>" <?php if ($category['ID'] == $transaction['IDCategoriaPrimaria']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['NomeCategoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <!-- Secondary Category Selection -->
            <div>
                <label for="secondaryCategoryId">Seleziona la Categoria Secondaria:</label>
                <select id="secondaryCategoryId" name="secondaryCategoryId">
                    <option value="" disabled selected>Per favore Seleziona la Categoria Secondaria</option>
                    <!-- Secondary categories will be populated here based on the primary category selected -->
                </select><br>
            </div>

            <!-- Submit button to save changes -->
            <div>
                <button type="submit">Save Changes</button>
            </div>
        </form>

        <!-- Form to delete the transaction -->
        <form action="../../server/eliminazione/delete_transaction.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID']); ?>">
            <button type="submit" style="background-color: red; color: white;">Delete Transaction</button>
        </form>
    <?php else : ?>
        <p>Transaction not found.</p>
    <?php endif; ?>

    <script>
        function updateSecondaryCategories() {
            var primaryCategoryId = $('#primaryCategoryId').val();
            console.log("Primary Category ID: ", primaryCategoryId); // Debugging line

            $.ajax({
                url: 'Server/get_secondary_categories.php', // Relative path corrected
                type: 'GET',
                data: {
                    primaryCategoryId: primaryCategoryId
                },
                dataType: 'json',
                success: function(categories) {
                    console.log("Received Categories:", categories); // Debugging line
                    var $secondarySelect = $('#secondaryCategoryId');
                    $secondarySelect.empty(); // Remove old options
                    $secondarySelect.append('<option disabled selected>Per favore Seleziona la Categoria Secondaria</option>');
                    categories.forEach(function(category) {
                        $secondarySelect.append($('<option>', {
                            value: category.ID,
                            text: category.NomeCategoria
                        }));
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText); // Debugging line
                }
            });
        }
    </script>
</body>

</html>