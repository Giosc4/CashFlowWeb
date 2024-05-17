<?php
require_once 'db_connection.php';
require_once 'queries.php';
require_once __DIR__ . '\mongo_connection.php';


function saveTransaction($isExpenseFlag, $amount, $accountId, $transactionDate, $primaryCategoryId, $secondaryCategoryId)
{
    global $conn, $insertTransaction ;

    $stmt = $conn->prepare($insertTransaction );
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("idisii", $isExpenseFlag, $amount, $accountId, $transactionDate, $primaryCategoryId, $secondaryCategoryId);

    if (!$stmt->execute()) {
        if ($stmt->errno == 45000) {  // Codice errore specifico per "Budget limit exceeded"
            return ['success' => false, 'message' => 'Budget limit exceeded for this category.'];
        } else {
            die('Error in execute statement: ' . $stmt->error);
        }
    }
    logEvent('saveTransaction', ['success' => true, 'details' => compact('isExpenseFlag', 'amount', 'accountId', 'transactionDate', 'primaryCategoryId', 'secondaryCategoryId')]);
    return ['success' => true];
}

function createConto($nome, $saldo)
{
    global $conn, $insertConto ;

    $stmt = $conn->prepare($insertConto );
    $stmt->bind_param("sd", $nome, $saldo);

    if ($stmt->execute()) {
        $insertID = $stmt->insert_id;
        logEvent('createConto', ['success' => true, 'insertId' => $insertID, 'details' => compact('nome', 'saldo')]);
        return $insertID;
    } else {
        return false;
    }
}


function createPrimaryCategory($nomeCategoria, $descrizioneCategoria)
{
    global $conn, $insertPrimaryCategory ;

    $stmt = $conn->prepare($insertPrimaryCategory );
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ss", $nomeCategoria, $descrizioneCategoria);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }
    $newCategoryId = $stmt->insert_id;
    $stmt->close();

    logEvent('createPrimaryCategory', ['success' => true, 'newCategoryId' => $newCategoryId, 'details' => compact('nomeCategoria', 'descrizioneCategoria')]);
    return $newCategoryId;
}

function createSecondaryCategory($idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria)
{
    global $conn, $insertSecondaryCategory ;

    $stmt = $conn->prepare($insertSecondaryCategory );
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("iss", $idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();
    logEvent('createSecondaryCategory', ['success' => true, 'details' => compact('idCategoriaPrimaria', 'nomeCategoria', 'descrizioneCategoria')]);
    return true;
}


function createRisparmio($amount, $risparmioDateInizio, $risparmioDateFine, $contoId, $primaryCategoryId)
{
    global $conn, $insertRisparmio ;

    $query = $insertRisparmio ;
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("dssii", $amount, $risparmioDateInizio, $risparmioDateFine, $contoId, $primaryCategoryId);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
    logEvent('createRisparmio', ['success' => true, 'details' => compact('amount', 'risparmioDateInizio', 'risparmioDateFine', 'contoId', 'primaryCategoryId')]);
    return true;
}

function createTransactionTemplate($templateName, $entryType, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description)
{
    global $conn, $insertTransactionTemplate ;

    $stmt = $conn->prepare($insertTransactionTemplate );
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("ssdiiss", $templateName, $entryType, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $lastId = $conn->insert_id;

    $stmt->close();

    logEvent('createTransactionTemplate', ['success' => true, 'lastId' => $lastId, 'details' => compact('templateName', 'entryType', 'amount', 'accountId', 'primaryCategoryId', 'secondaryCategoryId', 'description')]);
    return $lastId;
}

function createDebit($ImportoDebito, $NomeImporto, $DataConcessione, $DataEstinsione, $Note, $IDConto, $IDCategoriaPrimaria)
{
    global $conn, $insertDebit ;

    $stmt = $conn->prepare($insertDebit );

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sssssii", $ImportoDebito, $NomeImporto, $DataConcessione, $DataEstinsione, $Note, $IDConto, $IDCategoriaPrimaria);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
    logEvent('createDebit', ['success' => true, 'details' => compact('ImportoDebito', 'NomeImporto', 'DataConcessione', 'DataEstinsione', 'Note', 'IDConto', 'IDCategoriaPrimaria')]);
    return true;
}

function createCredit($importoCredito, $nomeImporto, $dataInizio, $dataFine, $note, $idConto, $IDCategoriaPrimaria)
{
    global $conn, $insertCredit ;

    $stmt = $conn->prepare($insertCredit );

    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    // Bind dei parametri
    $stmt->bind_param("sssssii", $importoCredito, $nomeImporto, $dataInizio, $dataFine, $note, $idConto, $IDCategoriaPrimaria);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();
    logEvent('createCredit', ['success' => true, 'details' => compact('importoCredito', 'nomeImporto', 'dataInizio', 'dataFine', 'note', 'idConto', 'IDCategoriaPrimaria')]);
    return true;
}

function createBudget($budgetName, $amount, $budgetStartDate, $budgetEndDate, $primaryCategory)
{
    global $conn, $insertBudget ;

    $stmt = $conn->prepare($insertBudget );

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sdssi", $budgetName, $amount, $budgetStartDate, $budgetEndDate, $primaryCategory);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
    logEvent('createBudget', ['success' => true, 'details' => compact('budgetName', 'amount', 'budgetStartDate', 'budgetEndDate', 'primaryCategory')]);
    return true;
}

function createProfile($nickname, $email, $password, $confirmPassword)
{
    global $conn, $insertProfile ;

    if (empty($nickname) || empty($email) || empty($password) || $password !== $confirmPassword) {
        return "Dati inseriti non validi.";
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare($insertProfile );
    if (!$stmt) {
        return 'Errore nella preparazione della query: ' . $conn->error;
    }

    $stmt->bind_param("sss", $nickname, $email, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        logEvent('createProfile', ['success' => true, 'details' => compact('nickname', 'email', 'hashedPassword')]);

        return "Profilo creato con successo.";
    } else {
        $stmt->close();
        $conn->close();
        return 'Errore nell\'esecuzione della query: ' . $stmt->error;
    }
}

function associaContoAProfilo($profiloID, $contoID)
{

    global $conn, $associateProfileToConto ;

    $stmt = $conn->prepare($associateProfileToConto );
    $stmt->bind_param("ii", $profiloID, $contoID);

    if (!$stmt->execute()) {
        die('Errore durante l\'associazione profilo-conto: ' . $stmt->error);
    }
    $stmt->close();
    return true;
}

function associateProfileToCategory($IDProfilo, $IDCategoriaPrimaria)
{
    global $conn, $associateProfileToCategory ;

    $stmt = $conn->prepare($associateProfileToCategory );
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ii", $IDProfilo, $IDCategoriaPrimaria);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }

    $stmt->close();
    return true;
}


function createTransactionFromTemplate($templateId)
{
    global $conn;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CALL CreateTransactionFromTemplate(?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('i', $templateId);

    if ($stmt->execute()) {
        echo "La transazione è stata creata con successo.";
        logEvent('createTransactionFromTemplate', ['success' => true, 'templateId' => $templateId]);
        return true;
    } else {
        echo "Errore nell'esecuzione: " . $stmt->error;
        return false;
    }

    $stmt->close();
}
