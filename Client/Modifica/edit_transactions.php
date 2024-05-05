<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: /CashFlowWeb/client/log_in_profile_client.php");
    exit();
}

require '../../db/read_functions.php';
// require '../../server/other_functions.php';

// Get transaction ID from query parameters
$id = $_GET['id'] ?? null;

// Fetch the transaction details from the database using the transaction ID
$transaction = $id ? getTransactionFromID($id) : null;

// Fetch accounts and categories
$accounts = getAllConti();
$primaryCategories = getAllPrimaryCategories();

// Check if transaction exists
if (!$transaction) {
    echo "Transaction not found.";
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
        <form action="update_transaction.php" method="post">
            <!-- Hidden field to send the transaction ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID']); ?>">

            <!-- Field to edit whether the transaction is an expense -->
            <div>
                <label for="isExpense">Is Expense:</label>
                <input type="checkbox" id="isExpense" name="isExpense" <?php echo ($transaction['Is_Expense'] ? 'checked' : ''); ?>><br>
            </div>

            <!-- Field to edit the transaction amount -->
            <div>
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($transaction['Importo']); ?>" step="0.01" required>
            </div>

            <!-- Field to edit the transaction date -->
            <div>
                <label for="date">Transaction Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($transaction['DataTransazione']); ?>" required>
            </div>

            <!-- Account Selection -->
            <div>
                <label for="accountId">Select an Account:</label>
                <select id="accountId" name="accountId" required>
                    <?php foreach ($accounts as $account) : ?>
                        <option value="<?php echo $account['ID']; ?>" <?php echo ($account['ID'] == $transaction['IDConto'] ? 'selected' : ''); ?>><?php echo $account['NomeConto']; ?></option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <!-- Primary Category Selection -->
            <div>
                <label for="primaryCategoryId">Select a Primary Category:</label>
                <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
                    <option value="" disabled selected>Please select a Primary Category</option>
                    <?php foreach ($primaryCategories as $category) : ?>
                        <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <!-- Secondary Category Selection -->
            <div>
                <label for="secondaryCategoryId">Select a Secondary Category:</label>
                <select id="secondaryCategoryId" name="secondaryCategoryId" >
                    <option value="" disabled selected>Please select a Secondary Category</option>
                </select><br>
            </div>

            <!-- Submit button to save changes -->
            <div>
                <button type="submit">Save Changes</button>
            </div>
        </form>

        <!-- Form to delete the transaction -->
        <form action="delete_transaction.php" method="post">
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
                url: 'C:/Users/giova/xampp/htdocs/CashFlowWeb/server/get_secondary_categories.php', // Ensure this is the correct relative path
                type: 'GET',
                data: {
                    primaryCategoryId: primaryCategoryId
                },
                dataType: 'json',
                success: function(categories) {
                    console.log("Received Categories:", categories); // Debugging line
                    var $secondarySelect = $('#secondaryCategoryId');
                    $secondarySelect.empty(); // Remove old options
                    $secondarySelect.append('<option disabled selected>Please select a Secondary Category</option>');
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