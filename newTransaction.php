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
    $positionCity = 1;  // Aggiunto valore di default
    $transactionDate = isset($_POST['transactionDate']) ? $_POST['transactionDate'] : date("Y-m-d"); // Data di oggi

    // Assegna i valori alle variabili $account e $category
    $account = ($accountId !== null) ? getAccountById($accountId) : null;
    $category = ($categoryId !== null) ? getCategoryById($categoryId) : null;

    if ($accountId !== null && $categoryId !== null && $account && $category) {

        // Salvataggio della transazione
        saveTransaction($isExpense, $amount, $account, $category, $positionCity, $transactionDate);
        
        header("Location: index.php");
        exit(); 
    } else {
        echo "Errore: L'account o la categoria selezionati non esistono.";
    }
}

function getAccountById($accountId)
{
    global $accounts;

    foreach ($accounts as $account) {
        if ($account->id == $accountId) {
            return $account;
        }
    }

    return null;
}

function getCategoryById($categoryId)
{
    global $categories;

    foreach ($categories as $category) {
        if ($category->id == $categoryId) {
            return $category;
        }
    }

    return null;
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
        <input type="number" id="amount" name="amount" step="0.01"autocomplete="off" required><br>

        <label for="accountId">Select an Account:</label>
        <select name="accountId">
            <option value="" disabled selected>Please select the Account</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account->id; ?>"><?php echo $account->name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoryId">Select a Category:</label>
        <select name="categoryId">
            <option value="" disabled selected>Please select a Category</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="transactionDate">Transaction Date:</label>
        <input type="date" id="transactionDate" name="transactionDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Transazione">
    </form>

</body>

</html>