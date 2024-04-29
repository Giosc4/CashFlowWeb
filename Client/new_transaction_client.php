<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Transazione</title>
</head>

<body>
    <h1>Creazione Transazione</h1>
    <form action="../server/new_transaction_server.php" method="post">

        <label for="isExpense">Is Expense:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <?php
        require_once '../server/other_functions.php';
        $accounts = getAllConti();
        $primaryCategories = getAllPrimaryCategories();
        ?>

        <label for="accountId">Select an Account:</label>
        <select name="accountId" required>
            <option value="" disabled selected>Please select the Account</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['id']; ?>"><?php echo $account['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoryId">Select a Category:</label>
        <select name="categoryId" required>
            <option value="" disabled selected>Please select a Category</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="transactionDate">Transaction Date:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Transazione">
    </form>

</body>

</html>