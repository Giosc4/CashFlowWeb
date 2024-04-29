<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';



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
function displayAllTables()
{
    $accounts = getAllAccounts();
    $categories = getAllCategories();
    $transactions = getAllTransactions();

    displayTableData($accounts, 'account');
    displayTableData($categories, 'categories');
    displayTableData($transactions, 'transaction');
}

// Recupera la lista degli account e delle categorie dal database
function setAccountsAndCategories()
{
    $accounts = getAllAccounts();
    $categories = getAllCategories();
    return ['accounts' => $accounts, 'categories' => $categories];
}
