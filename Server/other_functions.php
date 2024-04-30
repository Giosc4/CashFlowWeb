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
    $categoriePrimarie = getAllPrimaryCategories();
    $categorieSecondarie = getAllSecondaryCategories();
    $transactions = getAllTransactions();
    $profilo = getAllProfili();
    $transactions_template = getAllTransactionsTemplate();
    $risparmi = getAllRisparmi();
    $obiettivi = getAllObiettivi();
    $debiti = getAllDebiti();
    $crediti = getAllCrediti();
    $budgets = getAllBudgets();

    displayTableData($transactions, '1 Transazioni'); //TODO
    displayTableData($conti, '2 Conti');
    displayTableData($categoriePrimarie, '3 Categorie Primaria');
    displayTableData($categorieSecondarie, '4 Categorie Secondarie');
    displayTableData($profilo, '5 Profilo');
    displayTableData($transactions_template, '6 Template Transazioni');
    displayTableData($risparmi, '7 Risparmi');
    displayTableData($debiti, '8 Debiti');
    displayTableData($crediti, '9 Crediti');
    displayTableData($budgets, '10 Budget');
    displayTableData($obiettivi, '11 Obiettivi');
}