<?php
require_once '../db/write_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $templateName = $_POST['templateName'];
    $entryType = $_POST['entryType'];
    $amount = $_POST['amount'];
    $accountId = $_POST['accountId'];
    $primaryCategoryId = $_POST['primaryCategoryId'];
    $secondaryCategoryId = $_POST['secondaryCategoryId'];
    $description = $_POST['description'];

    createTransactionTemplate($templateName, $entryType, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description);

    header('Location: ../client/index.php');
    exit();
}
