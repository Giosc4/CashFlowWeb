<?php
require_once '../db/db.php';
require_once '../db/read_db.php';
require_once '../db/queries.php';
require_once '../server/classes.php';

function displayAllTables() {
    $accounts = getAllAccounts();
    $transactions = getAllTransactions();
    $categoriePrimarie = getAllCategoriePrimarie();
    $categorieSecondarie = getAllCategorieSecondarie();
    // Aggiungi qui altre chiamate di funzione

    displayTableData($accounts, 'account');
    displayTableData($transactions, 'transaction');
    displayTableData($categoriePrimarie, 'categoria primaria');
    displayTableData($categorieSecondarie, 'categoria secondaria');
    // Aggiungi qui altre chiamate a displayTableData
}

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


?>