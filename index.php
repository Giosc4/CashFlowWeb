<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Home Page</h1>
    <ul>
        <li><a href="newTransaction.php">Creazione Transazione</a></li>
        <li><a href="create_account.php">Creazione Account</a></li>
        <li><a href="create_category.php">Creazione Categoria</a></li>
    </ul>

    <h2>Contenuto delle tabelle</h2>

    <?php
    require_once 'queries.php';
    require_once 'read_functions.php';

    // Esempio di visualizzazione di tutte le tabelle
    $accounts = getAllAccounts();
    $categories = getAllCategories();
    $positions = getAllPositions();
    $transactions = getAllTransactions();

    // Funzione per visualizzare i dati di una tabella
    function displayTableData($data, $tableName)
    {
        echo "<h3>$tableName</h3>";

        if (!empty($data)) {
            echo "<table border='1'>";
            echo "<tr>";

            // Stampa gli header della tabella
            foreach ($data[0] as $key => $value) {
                echo "<th>$key</th>";
            }

            echo "</tr>";

            // Stampa i dati della tabella
            foreach ($data as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nessun dato presente nella tabella $tableName.";
        }
    }

    // Visualizza i dati delle tabelle
    displayTableData($accounts, 'account');
    displayTableData($categories, 'categories');
    displayTableData($positions, 'position');
    displayTableData($transactions, 'transaction');
    ?>
</body>

</html>