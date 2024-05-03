<?php
require_once '../db/db_connection.php';
require_once '../db/queries.php';


// questa funzione controlla se esiste un utente con la stessa email
function userExists($email)
{
    global $conn, $selectUserByEmailQuery;

    $stmt = $conn->prepare($selectUserByEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

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

function getAllProfili()
{
    global $conn, $selectAllProfiliQuery;

    $result = $conn->query($selectAllProfiliQuery);

    $profili = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $profilo = [
                'IDProfilo' => $row['IDProfilo'],
                'NomeProfilo' => $row['NomeProfilo'],
                'Saldo_totale' => $row['Saldo_totale'],
                'Email' => $row['Email'],
                'Password' => $row['Password']
            ];
            $profili[] = $profilo;
        }
    }

    return $profili;
}

function getAllTransactionsTemplate()
{
    global $conn, $selectAllTransactionsTemplateQuery;

    $result = $conn->query($selectAllTransactionsTemplateQuery);

    $transactions_template = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaction = [
                'NomeTemplate' => $row['NomeTemplate'],
                'Entrata_Uscita' => $row['Entrata_Uscita'],
                'Importo' => $row['Importo'],
                'IDConto' => $row['IDConto'],
                'IDCategoriaPrimaria' => $row['IDCategoriaPrimaria'],
                'IDCategoriaSecondaria' => $row['IDCategoriaSecondaria'],
                'Descrizione' => $row['Descrizione']
            ];
            $transactions_template[] = $transaction;
        }
    }

    return $transactions_template;
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
            $categories[] = [
                'NomeCategoria' => $row['NomeCategoria'],
                'DescrizioneCategoria' => $row['DescrizioneCategoria'],
                'ID' => $row['ID'],
            ];
        }
    }
    return $categories;
}


function getAllSecondaryCategories()
{
    global $conn, $selectAllSecondaryCategoriesQuery;

    $result = $conn->query($selectAllSecondaryCategoriesQuery);

    $categories = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = [
                'NomeCategoria' => $row['NomeCategoria'],
                'DescrizioneCategoria' => $row['DescrizioneCategoria'],
                'IDCategoriaPrimaria' => $row['IDCategoriaPrimaria'],
                'ID' => $row['ID'],
            ];
        }
    }
    return $categories;
}

function getSecondaryFromPrimaryCategories($primaryCategoryID)
{
    global $conn, $selectSecondaryFromPrimaryQuery;

    $stmt = $conn->prepare($selectSecondaryFromPrimaryQuery);
    $stmt->bind_param("i", $primaryCategoryID);
    $stmt->execute();
    $result = $stmt->get_result();

    $secondaryCategories = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $secondaryCategories[] = [
                'ID' => $row['ID'],
                'NomeCategoria' => $row['NomeCategoria'],
                'DescrizioneCategoria' => $row['DescrizioneCategoria'],
                'IDCategoriaPrimaria' => $row['IDCategoriaPrimaria']
            ];
        }
    }

    $stmt->close();
    return $secondaryCategories;
}


function getAllRisparmi()
{
    global $conn, $selectAllRisparmiQuery;

    $result = $conn->query($selectAllRisparmiQuery);

    $risparmi = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $risparmio = [
                'id' => $row['id'],
                'ImportoRisparmiato' => $row['ImportoRisparmiato'],
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
                'id' => $row['id'],
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

function getAllDebiti()
{
    global $conn, $selectAllDebitiQuery;

    $result = $conn->query($selectAllDebitiQuery);

    $debiti = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $debito = [
                'id' => $row['id'],
                'ImportoDebito' => $row['ImportoDebito'],
                'NomeImporto' => $row['NomeImporto'],
                'DataConcessione' => $row['DataConcessione'],
                'DataEstinsione' => $row['DataEstinsione'],
                'Note' => $row['Note'],
                'IDConto' => $row['IDConto']
            ];
            $debiti[] = $debito;
        }
    }

    return $debiti;
}

function getAllCrediti()
{
    global $conn, $selectAllCreditiQuery;

    $result = $conn->query($selectAllCreditiQuery);

    $crediti = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $credito = [
                'id' => $row['id'],
                'ImportoCredito' => $row['ImportoCredito'],
                'NomeImporto' => $row['NomeImporto'],
                'DataConcessione' => $row['DataConcessione'],
                'DataEstinsione' => $row['DataEstinsione'],
                'Note' => $row['Note'],
                'IDConto' => $row['IDConto']
            ];
            $crediti[] = $credito;
        }
    }

    return $crediti;
}


function getAllBudgets()
{
    global $conn, $selectAllBudgetQuery;

    $result = $conn->query($selectAllBudgetQuery);

    $Budgets = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Budget = [
                'IDBudget' => $row['IDBudget'],
                'NomeBudget' => $row['NomeBudget'],
                'ImportoMax' => $row['ImportoMax'],
                'DataInizio' => $row['DataInizio'],
                'DataFine' => $row['DataFine'],
                'IDPrimaryCategory' => $row['IDPrimaryCategory']
            ];
            $Budgets[] = $Budget;
        }
    }

    return $Budgets;
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

function getProfiloByEmail($email) {
    global $conn, $selectUserByEmailQuery; 

    $stmt = $conn->prepare($selectUserByEmailQuery);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row; // Return the whole row as an associative array.
    } else {
        $stmt->close();
        return false;
    }
}


function getIDProfiloByEmail($email)
{
    global $conn, $selectIDProfileByEmailQuery;

    $stmt = $conn->prepare($selectIDProfileByEmailQuery);
    if (!$stmt) {
        error_log("MySQL prepare error: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        error_log("Execute error: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row['IDProfilo'];
    } else {
        $stmt->close();
        return false;
    }
}


function logInProfile($email, $password)
{
    global $conn, $selectIDProfileByEmailQuery;

    $stmt = $conn->prepare($selectIDProfileByEmailQuery);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session and save the email to the session
            session_start();
            $_SESSION['email'] = $email;
            $stmt->close();
            return true;
        } else {
            // Password is incorrect
            echo "Errore: La password non è corretta.";
        }
    } else {
        // No account found with the provided email
        echo "Errore: Nessun account trovato con l'email '$email'.";
    }

    $stmt->close();
    return false;
}
