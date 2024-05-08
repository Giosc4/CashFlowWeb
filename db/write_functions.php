<?php
require_once 'db_connection.php';
require_once 'queries.php';

function saveTransaction($isExpenseFlag, $amount, $accountId, $transactionDate, $primaryCategoryId, $secondaryCategoryId)
{
    global $conn, $insertTransactionQuery;

    $stmt = $conn->prepare($insertTransactionQuery);

    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("idisii", $isExpenseFlag, $amount, $accountId, $transactionDate, $primaryCategoryId, $secondaryCategoryId);

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
    }
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

    $stmt = $conn->prepare($insertTransactionTemplateQuery);
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("ssdiiss", $templateName, $entryType, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $lastId = $conn->insert_id;

    $stmt->close();

    return $lastId;
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


function updateTransaction($transactionData)
{
    global $conn, $updateTransactionQuery;

    $stmt = $conn->prepare($updateTransactionQuery);
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
        return false;
    }

    $stmt->bind_param(
        "idisiii",
        $transactionData['Is_Expense'],
        $transactionData['Importo'],
        $transactionData['IDConto'],
        $transactionData['DataTransazione'],
        $transactionData['IDCategoriaPrimaria'],
        $transactionData['IDCategoriaSecondaria'],
        $transactionData['ID']
    );

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
        return false;
    }

    $stmt->close();

    return true;
}


function deleteTransaction($transactionID)
{
    global $conn, $deleteTransactionQuery;


    $stmt = $conn->prepare($deleteTransactionQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $transactionID);

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
    }

    $stmt->close();

    return true;
}

function updatePrimaryCategory($categoryId, $categoryName, $categoryDescription)
{
    global $conn, $updatePrimaryCategoryQuery;

    $stmt = $conn->prepare($updatePrimaryCategoryQuery);
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $categoryName, $categoryDescription, $categoryId);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();

    return true;
}

function deletePrimaryCategory($categoryID)
{
    global $conn, $deletePrimaryCategoryQuery;

    $stmt = $conn->prepare($deletePrimaryCategoryQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $categoryID);

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
    }

    $stmt->close();

    return true;
}

function updateSecondaryCategory($categoryId, $categoryName, $primaryCategoryId, $categoryDescription)
{
    global $conn, $updateSecondaryCategoryQuery;

    $stmt = $conn->prepare($updateSecondaryCategoryQuery);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }

    $bind = $stmt->bind_param("ssii", $categoryName, $categoryDescription, $primaryCategoryId, $categoryId);
    if (!$bind) {
        echo "Error binding parameters: " . $stmt->error;
        return false;
    }

    $execute = $stmt->execute();
    if (!$execute) {
        echo "Error executing update: " . $stmt->error;
        return false;
    }

    return true;
}

// Funzione per eliminare una categoria secondaria
function deleteSecondaryCategory($categoryId)
{
    global $conn, $deleteSecondaryCategoryQuery;

    $stmt = $conn->prepare($deleteSecondaryCategoryQuery);
    if (!$stmt) {
        throw new Exception('Error preparing query: ' . $conn->error);
    }

    $stmt->bind_param("i", $categoryId);
    if (!$stmt->execute()) {
        $stmt->close();
        throw new Exception('Error executing query: ' . $stmt->error);
    }

    $stmt->close();
    return true;
}


function updateAccount($accountId, $accountName, $accountBalance)
{
    global $conn, $updateContoQuery;

    $stmt = $conn->prepare($updateContoQuery);
    if (!$stmt) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    $stmt->bind_param("sdi", $accountName, $accountBalance, $accountId);

    if (!$stmt->execute()) {
        die('Errore nell\'esecuzione della query: ' . $stmt->error);
    }

    $stmt->close();

    return true;
}

function deleteAccount($accountId)
{
    global $conn, $deleteContoQuery;

    $stmt = $conn->prepare($deleteContoQuery);
    if (!$stmt) {
        echo 'Errore nella preparazione della query: ' . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $accountId);

    if (!$stmt->execute()) {
        echo 'Errore nell\'esecuzione della query: ' . $stmt->error;
        return false;
    }

    $stmt->close();

    return true;
}

function updateTemplateTransaction($templateId, $templateName, $isExpense, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description)
{
    global $conn, $updateTemplateTransactionQuery;

    $stmt = $conn->prepare($updateTemplateTransactionQuery);
    $stmt->bind_param("sidiiisi", $templateName, $isExpense, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description, $templateId);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

function deleteTemplateTransaction($templateId)
{
    global $conn, $deleteTemplateTransactionQuery;

    $stmt = $conn->prepare($deleteTemplateTransactionQuery);
    $stmt->bind_param("i", $templateId);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

function updateRisparmio($risparmioId, $amount, $risparmioDateInizio, $risparmioDateFine, $contoId)
{
    global $conn, $updateRisparmioQuery;

    $stmt = $conn->prepare($updateRisparmioQuery);
    $stmt->bind_param("dssii", $amount, $risparmioDateInizio, $risparmioDateFine, $contoId, $risparmioId);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}


function deleteRisparmio($risparmioId)
{
    global $conn, $deleteRisparmioQuery;

    $stmt = $conn->prepare($deleteRisparmioQuery);
    $stmt->bind_param("i", $risparmioId);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

function updateBudget($budgetData)
{
    global $conn, $updateBudgetQuery;

    $stmt = $conn->prepare($updateBudgetQuery);
    if (!$stmt) {
        die('Error in prepare statement: ' . $conn->error);
        return false;
    }

    // Assicurati che l'ordine e i tipi di bind_param corrispondano ai dati del budget
    $stmt->bind_param(
        "sdssii",
        $budgetData['NomeBudget'],
        $budgetData['ImportoMax'],
        $budgetData['DataInizio'],
        $budgetData['DataFine'],
        $budgetData['IDPrimaryCategory'],
        $budgetData['ID']
    );

    if (!$stmt->execute()) {
        die('Error in execute statement: ' . $stmt->error);
        return false;
    }

    $stmt->close();

    return true;
}

function deleteBudget($budgetID)
{
    global $conn, $deleteBudgetQuery;

    $stmt = $conn->prepare($deleteBudgetQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $budgetID);

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
    }

    $stmt->close();

    return true;
}

function updateDebito($debtData)
{
    global $conn, $updateDebitoQuery;

    $stmt = $conn->prepare($updateDebitoQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param(
        "dssssiii",
        $debtData['ImportoDebito'],
        $debtData['NomeImporto'],
        $debtData['DataConcessione'],
        $debtData['DataEstinsione'],
        $debtData['Note'],
        $debtData['IDConto'],
        $debtData['IDCategoriaPrimaria'],
        $debtData['ID']
    );

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
    }

    $stmt->close();
    return true;
}

function deleteDebito($debtID)
{
    global $conn, $deleteDebitoQuery;


    $stmt = $conn->prepare($deleteDebitoQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $debtID);

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
    }

    $stmt->close();
    return true;
}

function updateCredit($creditData)
{
    global $conn, $updateCreditoQuery;

    $stmt = $conn->prepare($updateCreditoQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param(
        "dssssiii",
        $creditData['ImportoCredito'],
        $creditData['NomeCredito'],
        $creditData['DataConcessione'],
        $creditData['DataEstinsione'],
        $creditData['Note'],
        $creditData['IDConto'],
        $creditData['IDCategoriaPrimaria'],
        $creditData['ID']
    );

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
    }

    $stmt->close();
    return true;
}


function deleteCredit($creditID)
{
    global $conn, $deleteCreditoQuery;

    $stmt = $conn->prepare($deleteCreditoQuery);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $creditID);

    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return false;
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
        return true;
    } else {
        echo "Errore nell'esecuzione: " . $stmt->error;
        return false;
    }

    $stmt->close();
}
