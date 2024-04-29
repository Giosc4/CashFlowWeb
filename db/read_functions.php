<?php
require_once '../db/db_connection.php';
require_once '../db/queries.php';
require_once '../server/classes.php';


function getAllTransactions()
{
    global $conn, $selectAllTransactionsQuery;

    $result = $conn->query($selectAllTransactionsQuery);

    $transactions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }

    return $transactions;
}

function getAllConti()
{
    global $conn, $selectAllContiQuery;

    $result = $conn->query($selectAllContiQuery);

    $conti = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $conto = [
                'IDConto' => $row['IDConto'],
                'NomeConto' => $row['NomeConto'],
                'Saldo' => $row['Saldo']
            ];
            $conti[] = $conto;
        }
    }
    return $conti;
}


function getAllPrimaryCategories()
{
    global $conn, $selectAllPrimaryCategoriesQuery;

    $result = $conn->query($selectAllPrimaryCategoriesQuery);

    $categories = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (isset($row['id'])) {
                $categories[] = new CategoriaPrimaria($row['name'], $row['descriprion'], $row['id']);
            } else {
                echo "Errore: Chiave 'id' non presente nell'array.";
            }
        }
    }
    return $categories;
}

function getAllRisparmi()
{
    global $conn, $selectAllRisparmiQuery;

    $result = $conn->query($selectAllRisparmiQuery);

    $risparmi = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $risparmio = [
                'IDRisparmio' => $row['ID'],
                'Amount' => $row['ImportoRisparmiato'],
                'DataInizio' => $row['DataInizio'],
                'DataFine' => $row['DataFine'],
                'IDConto' => $row['IDConto']
            ];
            $risparmi[] = $risparmio;
        }
    }

    return $risparmi;
}

function getAllObiettivi()
{
    global $conn, $selectAllObiettiviQuery;

    $result = $conn->query($selectAllObiettiviQuery);

    $obiettivi = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $obiettivo = [
                'IDObiettivo' => $row['ID'],
                'NomeObiettivo' => $row['NomeObiettivo'],
                'ImportoObiettivo' => $row['ImportoObiettivo'],
                'DataScadenza' => $row['DataScadenza'],
                'IDConto' => $row['IDConto']
            ];
            $obiettivi[] = $obiettivo;
        }
    }

    return $obiettivi;
}


function getIdContoFromNome($nomeConto)
{
    global $conn, $selectIdContoFromNomeQuery;

    $stmt = $conn->prepare($selectIdContoFromNomeQuery);
    $stmt->bind_param("s", $nomeConto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (isset($row['IDConto'])) {
            $idConto = $row['IDConto'];
            $stmt->close();
            return $idConto;
        } else {
            echo "Errore: Chiave 'IDConto' non presente nell'array.";
        }
    } else {
        echo "Errore: Nessun conto trovato con il nome '$nomeConto'.";
    }

    $stmt->close();
    return null;
}
