<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Template Transazione</title>
</head>

<body>
    <h1>Creazione Template Transazione</h1>
    <form action="../server/new_transaction_server.php" method="post">

        <label for="isExpense">E' una spesa?</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Valore:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <?php
        require_once '../server/other_functions.php';
        $data = setAccountsAndCategories();
        $accounts = $data['accounts'];
        $categories = $data['categories'];
        ?>

        <label for="accountId">Seleziona un conto:</label>
        <select name="accountId" required>
            <option value="" disabled selected>Please seleziona un conto</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account->id; ?>"><?php echo $account->name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoryId">Seleziona un a Categoria Primaria:</label>
        <select name="categoryId" required>
            <option value="" disabled selected>Please seleziona un a Categoria Primaria</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="transactionDate">Data Transazione:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Transazione">
    </form>

</body>

</html>