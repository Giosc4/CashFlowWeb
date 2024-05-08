<?php





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

    return $secondaryCategories;
    $stmt->close();
}

function getSecondaryCategoryFromID($categoryId)
{
    global $conn, $selectSecondaryCategoryFromIDQuery;

    $stmt = $conn->prepare($selectSecondaryCategoryFromIDQuery);
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
    global $conn, $selectAccountByIdQuery;

    $stmt = $conn->prepare($selectAccountByIdQuery);
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
    global $conn, $selectTemplateTransactionFromIDQuery;

    $stmt = $conn->prepare($selectTemplateTransactionFromIDQuery);
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
    global $conn, $selectTransactionFromIDQuery;

    $stmt = $conn->prepare($selectTransactionFromIDQuery);
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
    global $conn, $selectCategoriaPrimariaByIdQuery;

    $stmt = $conn->prepare($selectCategoriaPrimariaByIdQuery);
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
    global $conn, $selectSavingFromIDQuery;

    $stmt = $conn->prepare($selectSavingFromIDQuery);
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

    global $conn, $selectBudgetFromIDQuery;

    $stmt = $conn->prepare($selectBudgetFromIDQuery);
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
    global $conn, $selectDebitFromIDQuery;


    $stmt = $conn->prepare($selectDebitFromIDQuery);
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
    global $conn, $selectCreditFromIDQuery;

    $stmt = $conn->prepare($selectCreditFromIDQuery);
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
