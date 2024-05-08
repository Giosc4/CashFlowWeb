<?php
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
