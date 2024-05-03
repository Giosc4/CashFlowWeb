<?php
require_once '../db/db_connection.php';
require_once '../db/queries.php';

function saveTransaction($isExpense, $amount, $account, $primaryCategory, $secondaryCategory, $transactionDate)
{
    global $conn, $insertTransactionQuery;

    $stmt = $conn->prepare($insertTransactionQuery);
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $description = "Transaction for " . $primaryCategory['NomeCategoria'];
    $isExpenseFlag = $isExpense ? 1 : 0;
    $stmt->bind_param("idisiis", $isExpenseFlag, $amount, $account['IDConto'], $transactionDate, $primaryCategory['ID'], $secondaryCategory['ID'], $description);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}


function createConto($nome, $saldo)
{
    global $conn, $insertContoQuery;

    $stmt = $conn->prepare($insertContoQuery);
    $stmt->bind_param("sd", $nome, $saldo);

    if ($stmt->execute()) {
        return $conn->insert_id; // Returns the auto-increment ID of the last inserted row
    } else {
        return false;
    }
}


function createPrimaryCategory($nomeCategoria, $descrizioneCategoria)
{
    global $conn, $insertPrimaryCategoryQuery;

    $stmt = $conn->prepare($insertPrimaryCategoryQuery);
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ss", $nomeCategoria, $descrizioneCategoria);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }
    $newCategoryId = $stmt->insert_id;
    $stmt->close();

    return $newCategoryId;
}

function createSecondaryCategory($idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria)
{
    global $conn, $insertSecondaryCategoryQuery;

    $stmt = $conn->prepare($insertSecondaryCategoryQuery);
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("iss", $idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();
}


function createRisparmio($amount, $risparmioDateInizio, $risparmioDateFine, $contoId)
{
    global $conn, $insertRisparmioQuery;

    $query = $insertRisparmioQuery;
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("dssi", $amount, $risparmioDateInizio, $risparmioDateFine, $contoId);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}

function createObiettivo($name, $amount, $date_inizio, $conto_id)
{
    global $conn, $insertObiettivoQuery;

    $stmt = $conn->prepare($insertObiettivoQuery);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sdsi", $name, $amount, $date_inizio, $conto_id);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}
function createTransactionTemplate($templateName, $entryType, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description)
{
    global $conn, $insertTransactionTemplateQuery;

    // Preparazione della query
    $stmt = $conn->prepare($insertTransactionTemplateQuery);
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("ssdiiss", $templateName, $entryType, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();
}


function createDebit($ImportoDebito, $NomeImporto, $DataConcessione, $DataEstinsione, $Note, $IDConto)
{
    global $conn, $insertDebitQuery;

    $stmt = $conn->prepare($insertDebitQuery);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sssssi", $ImportoDebito, $NomeImporto, $DataConcessione, $DataEstinsione, $Note, $IDConto);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}


// Funzione per creare un credito nel database
function createCredit($importoCredito, $nomeImporto, $dataInizio, $dataFine, $note, $idConto)
{
    global $conn, $insertCreditQuery;

    $stmt = $conn->prepare($insertCreditQuery);

    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    // Bind dei parametri
    $stmt->bind_param("sssssi", $importoCredito, $nomeImporto, $dataInizio, $dataFine, $note, $idConto);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();
}


function createBudget($budgetName, $amount, $budgetStartDate, $budgetEndDate, $primaryCategory)
{
    global $conn, $insertBudgetQuery;

    $stmt = $conn->prepare($insertBudgetQuery);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sdssi", $budgetName, $amount, $budgetStartDate, $budgetEndDate, $primaryCategory);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}

function createProfile($nickname, $email, $password, $confirmPassword)
{
    global $conn, $insertProfileQuery;

    if (empty($nickname) || empty($email) || empty($password) || $password !== $confirmPassword) {
        return "Dati inseriti non validi.";
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare($insertProfileQuery);
    if (!$stmt) {
        return 'Errore nella preparazione della query: ' . $conn->error;
    }

    // Collegamento dei parametri alla query
    $stmt->bind_param("sss", $nickname, $email, $hashedPassword);

    // Esecuzione della query
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return "Profilo creato con successo.";
    } else {
        $stmt->close();
        $conn->close();
        return 'Errore nell\'esecuzione della query: ' . $stmt->error;
    }
}
function associaContoAProfilo($profiloID, $contoID)
{

    global $conn, $associateProfileToContoQuery;

    $stmt = $conn->prepare($associateProfileToContoQuery);
    $stmt->bind_param("ii", $profiloID, $contoID);

    if (!$stmt->execute()) {
        die('Errore durante l\'associazione profilo-conto: ' . $stmt->error);
    }
    $stmt->close();
}

function associateProfileToCategory($IDProfilo, $IDCategoriaPrimaria)
{
    global $conn, $associateProfileToCategoryQuery;

    $stmt = $conn->prepare($associateProfileToCategoryQuery);
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ii", $IDProfilo, $IDCategoriaPrimaria);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
}