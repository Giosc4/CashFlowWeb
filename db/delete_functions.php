<?php
function deleteTransaction($transactionID)
{
    global $conn, $deleteTransaction ;


    $stmt = $conn->prepare($deleteTransaction );
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
    global $conn, $deletePrimaryCategory ;

    $stmt = $conn->prepare($deletePrimaryCategory );
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
    global $conn, $deleteSecondaryCategory ;

    $stmt = $conn->prepare($deleteSecondaryCategory );
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
    global $conn, $deleteConto ;

    $stmt = $conn->prepare($deleteConto );
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
    global $conn, $deleteTemplateTransaction ;

    $stmt = $conn->prepare($deleteTemplateTransaction );
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
    global $conn, $deleteRisparmio ;

    $stmt = $conn->prepare($deleteRisparmio );
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
    global $conn, $deleteBudget ;

    $stmt = $conn->prepare($deleteBudget );
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
    global $conn, $deleteDebito ;


    $stmt = $conn->prepare($deleteDebito );
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
    global $conn, $deleteCredito ;

    $stmt = $conn->prepare($deleteCredito );
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
