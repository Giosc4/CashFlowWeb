<?php


require_once 'db_connection.php';
require_once 'queries.php';



function getSecondaryFromPrimaryCategories($primaryCategoryID)
{
    global $conn, $selectSecondaryFromPrimary;

    $stmt = $conn->prepare($selectSecondaryFromPrimary);
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

function getSecondaryCategoryFromID($categoryId)
{
    global $conn, $selectSecondaryCategoryFromID;

    $stmt = $conn->prepare($selectSecondaryCategoryFromID);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return false;
    }
}

function getAccountById($accountId)
{
    global $conn, $selectAccountById;

    $stmt = $conn->prepare($selectAccountById);
    $stmt->bind_param("i", $accountId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return null;
    }
}


function getTemplateTransactionFromID($templateId)
{
    global $conn, $selectTemplateTransactionFromID;

    $stmt = $conn->prepare($selectTemplateTransactionFromID);
    $stmt->bind_param("i", $templateId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return null;
    }
}


function getTransactionFromID($id)
{
    global $conn, $selectTransactionFromID;

    $stmt = $conn->prepare($selectTransactionFromID);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return false;
    }
}


function getPrimaryCategoryById($categoryId)
{
    global $conn, $selectCategoriaPrimariaById;

    $stmt = $conn->prepare($selectCategoriaPrimariaById);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return false;
    }
}


function getSavingFromID($risparmioId)
{
    global $conn, $selectSavingFromID;

    $stmt = $conn->prepare($selectSavingFromID);
    if (!$stmt) {
        error_log("MySQL prepare error: " . $conn->error);
        return false;
    }

    $stmt->bind_param("i", $risparmioId);

    if (!$stmt->execute()) {
        error_log("Execute error: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return null;
    }
}

function getBudgetFromID($budgetID)
{

    global $conn, $selectBudgetFromID;

    $stmt = $conn->prepare($selectBudgetFromID);
    $stmt->bind_param("i", $budgetID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } else {
        $stmt->close();
        return false;
    }
}

function getDebtFromID($id)
{
    global $conn, $selectDebitFromID;


    $stmt = $conn->prepare($selectDebitFromID);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return null;
    }

    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return null;
    }

    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $stmt->close();
        return null;
    }

    $debt = $result->fetch_assoc();
    $stmt->close();
    return $debt;
}

function getCreditFromID($id)
{
    global $conn, $selectCreditFromID;

    $stmt = $conn->prepare($selectCreditFromID);
    if (!$stmt) {
        echo 'Error in prepare statement: ' . $conn->error;
        return null;
    }

    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        echo 'Error in execute statement: ' . $stmt->error;
        return null;
    }

    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $stmt->close();
        return null;
    }

    $credit = $result->fetch_assoc();
    $stmt->close();
    return $credit;
}
