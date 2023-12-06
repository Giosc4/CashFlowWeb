<?php
require_once 'write_functions.php';
require_once 'read_functions.php';
require_once 'classes.php';


// Recupera la lista degli account e delle categorie dal database
$accounts = getAllAccounts();
$categories = getAllCategories();

$account = null;
$category = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal modulo HTML e crea l'oggetto Transaction
    $isExpense = isset($_POST['isExpense']) ? true : false;
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.0;
    $accountId = isset($_POST['accountId']) ? intval($_POST['accountId']) : null;
    $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : null;
    $transactionDate = isset($_POST['transactionDate']) ? $_POST['transactionDate'] : date("Y-m-d"); // Data di oggi

    // Assegna i valori alle variabili $account e $category
    $account = ($accountId !== null) ? getAccountById($accountId) : null;
    $category = ($categoryId !== null) ? getCategoryById($categoryId) : null;

    if ($accountId !== null && $categoryId !== null && $account && $category) {
        // Creazione dell'oggetto Transaction
        $transaction = new Transaction(null, $isExpense, $amount, $account, $category, null, $transactionDate);

        // Salvataggio della transazione
        saveTransaction($transaction->isExpense, $transaction->amount, $transaction->account->id, $transaction->category->id, null, $transaction->transactionDate);

        // Esempio di lettura di tutte le transazioni
        $transactions = getAllTransactions();
        header("Location: index.php");
        exit(); // Termina lo script dopo il reindirizzamento
    } else {
        echo "Errore: L'account o la categoria selezionati non esistono.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Transazione</title>
</head>

<body>
    <h1>Creazione Transazione</h1>
    <form action="newTransaction.php" method="post">
        <label for="isExpense">Is Expense:</label>
        <input type="checkbox" id="isExpense" name="isExpense"><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01"><br>

        <label for="accountId">Select Account:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled selected>Please select an account</option>
            <?php foreach ($accounts as $account) : ?>
                <?php
                $accountIdValue = isset($account['id']) ? $account['id'] : null;
                $selected = ($accountIdValue == $accountId) ? 'selected' : '';
                ?>
                <option value="<?php echo $accountIdValue; ?>" <?php echo $selected; ?>><?php echo $account['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoryId">Select Category:</label>
        <select id="categoryId" name="categoryId" required>
            <option value="" disabled selected>Please select a category</option>
            <?php foreach ($categories as $category) : ?>
                <?php
                $categoryIdValue = isset($category['id']) ? $category['id'] : null;
                $selected = ($categoryIdValue == $categoryId) ? 'selected' : '';
                ?>
                <option value="<?php echo $categoryIdValue; ?>" <?php echo $selected; ?>><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select><br>


        <label for="transactionDate">Transaction Date:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Transazione">
    </form>
</body>

</html>