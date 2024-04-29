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
    $conti = getAllConti(); 
    $categories = getAllPrimaryCategories();
    $transactions = getAllTransactions();
    $risparmi = getAllRisparmi();
    $obiettivi = getAllObiettivi();

    displayTableData($conti, 'Conti');
    displayTableData($categories, 'categories');
    displayTableData($transactions, 'transaction');
    displayTableData($risparmi, 'risparmi');
    displayTableData($obiettivi, 'obiettivi');
}