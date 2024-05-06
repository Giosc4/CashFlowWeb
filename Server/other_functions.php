<?php
require '../db/write_functions.php';
require '../db/queries.php';
require '../db/read_functions.php';

//\Server\other_functions.php

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
        echo "<th>Action</th>";

        echo "</tr>";
        // Print the data of the table
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }

            echo "<td><a href='edit_manager.php?table=$tableName&id=" . $row['ID'] . "'><button style='background-color: red; color: white;'>Modifica</button></a></td>";

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
    if (!isset($_SESSION['email'])) {
        header("Location: ./log_in_profile_client.php");
        exit();
    }
    $email = $_SESSION['email'];
    global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail,
     $selectCategoriaSecondariaFromEmail, $selectTransazioniFromEmail, $selectTransazioniTemplateFromEmail,
      $selectRisparmiFromEmail, $selectObiettiviFromEmail, $selectDebitiFromEmail,  $selectCreditiFromEmail, $selectBudgetFromEmail;

    $conti = getTableBYEmail($email, $selectContoFromEmail);
    $categoriePrimarie = getTableBYEmail($email, $selectCategoriaPrimariaFromEmail);
    $categorieSecondarie = getTableBYEmail($email, $selectCategoriaSecondariaFromEmail);;
    $transactions = getTableBYEmail($email, $selectTransazioniFromEmail);
    $transactions_template = getTableBYEmail($email, $selectTransazioniTemplateFromEmail);
    $risparmi = getTableBYEmail($email, $selectRisparmiFromEmail);
    $obiettivi = getTableBYEmail($email, $selectObiettiviFromEmail);
    $debiti = getTableBYEmail($email, $selectDebitiFromEmail);
    $crediti = getTableBYEmail($email, $selectCreditiFromEmail);
    $budgets = getTableBYEmail($email, $selectBudgetFromEmail);

    displayTableData($transactions, '1 Transazioni');
    displayTableData($conti, '2 Conti');
    displayTableData($categoriePrimarie, '3 Categorie Primaria');
    displayTableData($categorieSecondarie, '4 Categorie Secondarie');
    displayTableData($transactions_template, '6 Template Transazioni');
    displayTableData($risparmi, '7 Risparmi');
    displayTableData($debiti, '8 Debiti');
    displayTableData($crediti, '9 Crediti');
    displayTableData($budgets, '10 Budget');
    displayTableData($obiettivi, '11 Obiettivi');
}
