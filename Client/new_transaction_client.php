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
    <form action="../server/new_transaction_server.php" method="post">
        <!-- Expense Checkbox -->
        <label for="isExpense">Is Expense:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <!-- Amount Input -->
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <!-- PHP to load accounts and categories -->
        <?php
        require_once '../server/other_functions.php';
        $accounts = getAllConti();
        $primaryCategories = getAllPrimaryCategories();
        ?>

        <!-- Account Selection -->
        <label for="accountId">Select an Account:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled selected>Please select the Account</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['IDConto']; ?>"><?php echo $account['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <!-- Primary Category Selection -->
        <label for="primaryCategoryId">Select a Primary Category:</label>
        <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
            <option value="" disabled selected>Please select a Primary Category</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <!-- Secondary Category Selection -->
        <label for="secondaryCategoryId">Select a Secondary Category:</label>
        <select id="secondaryCategoryId" name="secondaryCategoryId" required>
            <option value="" disabled selected>Please select a Secondary Category</option>
        </select><br>

        <!-- Transaction Date -->
        <label for="transactionDate">Transaction Date:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <!-- Submit Button -->
        <input type="submit" value="Crea Transazione">
    </form>

    <script>
        function updateSecondaryCategories() {
            var primaryCategoryId = $('#primaryCategoryId').val();
            console.log("Primary Category ID: ", primaryCategoryId); // Debugging line

            $.ajax({
                url: '../server/get_secondary_categories.php', // Ensure this is the correct relative path
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