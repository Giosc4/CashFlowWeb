<?php

// Funzione per visualizzare i dati di una tabella
function displayTableData($data, $tableName)
{
    echo "<h3>$tableName</h3>";

    if (!empty($data)) {
        echo "<table>";
        echo "<tr>";

        // Stampa gli header della tabella
        foreach ($data[0] as $key => $value) {
            echo "<th>$key</th>";
        }
        echo "<th>Modifica</th>";

        echo "</tr>";
        // Stampa i dati della tabella
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }

            echo "<td><a href='edit_manager.php?table=$tableName&id=" . $row['ID'] . "'><button class='btn-edit'>Modifica</button></a></td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nessun dato presente nella tabella $tableName.";
    }
}

function displayTableTemplate($data, $tableName)
{
    echo "<h3>$tableName</h3>";

    if (!empty($data)) {
        echo "<table>";
        echo "<tr>";

        // Stampa gli header della tabella
        foreach ($data[0] as $key => $value) {
            echo "<th>$key</th>";
        }
        echo "<th>Modifica</th>";
        echo "<th>Nuovo</th>";

        echo "</tr>";
        // Stampa i dati della tabella
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }

            echo "<td><a href='edit_manager.php?table=$tableName&id=" . $row['ID'] . "'><button class='btn-edit'>Modifica</button></a></td>";

            // Aggiungi una colonna con un pulsante verde con scritto 'Create Transaction' che apre una pagina chiamata 'from_template_transaction.php' che prende l'id del template e crea una transazione con la stored procedure
            echo "<td><a href='../server/from_template_transaction.php?templateID=" . $row['ID'] . "'><button class='btn-create'>Crea Transazione</button></a></td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nessun dato presente nella tabella $tableName.";
    }
}

function displayTableDebitCredit($data, $tableName, $type)
{
    echo "<h3>$tableName</h3>";

    if (!empty($data)) {
        echo "<table>";
        echo "<tr>";

        // Stampa gli header della tabella
        foreach ($data[0] as $key => $value) {
            echo "<th>$key</th>";
        }
        echo "<th>Modifica</th>";
        echo "<th>Nuovo</th>";

        echo "</tr>";
        // Stampa i dati della tabella
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }

            echo "<td><a href='edit_manager.php?table=$tableName&id=" . $row['ID'] . "'><button class='btn-edit'>Modifica</button></a></td>";

            // Aggiungi una colonna con un pulsante verde con scritto 'Fine' che apre una pagina chiamata 'from_debit_credit.php' che prende l'id del debito o credito e crea una transazione per terminare il debito o il credito
            echo "<td><a href='../server/from_debit_credit.php?debitCredit_ID=" . $row['ID'] . "&type=$type'><button class='btn-create'>Fine</button></a></td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nessun dato presente nella tabella $tableName.";
    }
}

function displayAllTables()
{
    if (!isset($_SESSION['email'])) {
        header("Location: ./log_in_profile_client.php");
        exit();
    }
    $email = $_SESSION['email'];
    global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail,
        $selectCategoriaSecondariaFromEmail, $selectTransazioniFromEmail, $selectTransazioniTemplateFromEmail,
        $selectRisparmiFromEmail,  $selectDebitiFromEmail,  $selectCreditiFromEmail, $selectBudgetFromEmail;

    $conti = getTableBYEmail($email, $selectContoFromEmail);
    $categoriePrimarie = getTableBYEmail($email, $selectCategoriaPrimariaFromEmail);
    $categorieSecondarie = getTableBYEmail($email, $selectCategoriaSecondariaFromEmail);;
    $transactions = getTableBYEmail($email, $selectTransazioniFromEmail);
    $transactions_template = getTableBYEmail($email, $selectTransazioniTemplateFromEmail);
    $risparmi = getTableBYEmail($email, $selectRisparmiFromEmail);
    $debiti = getTableBYEmail($email, $selectDebitiFromEmail);
    $crediti = getTableBYEmail($email, $selectCreditiFromEmail);
    $budgets = getTableBYEmail($email, $selectBudgetFromEmail);

    displayTableData($transactions, '1 Transazioni');
    displayTableData($conti, '2 Conti');
    displayTableData($categoriePrimarie, '3 Categorie Primaria');
    displayTableData($categorieSecondarie, '4 Categorie Secondarie');
    displayTableTemplate($transactions_template, '6 Template Transazioni');
    displayTableData($risparmi, '7 Risparmi');
    displayTableDebitCredit($debiti, '8 Debiti', 'debit');
    displayTableDebitCredit($crediti, '9 Crediti', 'credit');
    displayTableData($budgets, '10 Budget');
}
