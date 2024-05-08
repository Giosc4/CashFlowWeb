<?php
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $templateName = $_POST['templateName'];
    $isExpense = $_POST['isExpense'];
    $amount = $_POST['amount'];
    $accountId = $_POST['accountId'];
    $primaryCategoryId = $_POST['primaryCategoryId'];
    $secondaryCategoryId = $_POST['secondaryCategoryId'];
    $description = $_POST['description'];

    $templateID =  createTransactionTemplate($templateName, $isExpense, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description);

    header('Location: ../../client/index.php');
    exit();
}
