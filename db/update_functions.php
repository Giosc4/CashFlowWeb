<?php

function updateTransaction($transactionData)
{
    global $conn, $updateTransaction ;

    $stmt = $conn->prepare($updateTransaction );
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

function updatePrimaryCategory($categoryId, $categoryName, $categoryDescription)
{
    global $conn, $updatePrimaryCategory ;

    $stmt = $conn->prepare($updatePrimaryCategory );
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

function updateSecondaryCategory($categoryId, $categoryName, $primaryCategoryId, $categoryDescription)
{
    global $conn, $updateSecondaryCategory ;

    $stmt = $conn->prepare($updateSecondaryCategory );
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

function updateAccount($accountId, $accountName, $accountBalance)
{
    global $conn, $updateConto ;

    $stmt = $conn->prepare($updateConto );
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

function updateTemplateTransaction($templateId, $templateName, $isExpense, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description)
{
    global $conn, $updateTemplateTransaction ;

    $stmt = $conn->prepare($updateTemplateTransaction );
    $stmt->bind_param("sidiiisi", $templateName, $isExpense, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description, $templateId);

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
    global $conn, $updateRisparmio ;

    $stmt = $conn->prepare($updateRisparmio );
    $stmt->bind_param("dssii", $amount, $risparmioDateInizio, $risparmioDateFine, $contoId, $risparmioId);

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
    global $conn, $updateBudget ;

    $stmt = $conn->prepare($updateBudget );
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

function updateDebito($debtData)
{
    global $conn, $updateDebito ;

    $stmt = $conn->prepare($updateDebito );
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

function updateCredit($creditData)
{
    global $conn, $updateCredito ;

    $stmt = $conn->prepare($updateCredito );
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
