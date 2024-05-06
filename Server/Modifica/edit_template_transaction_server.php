<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require '../../db/write_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $templateId = $_POST['templateId'];
    $templateName = $_POST['templateName'];
    $isExpense = isset($_POST['isExpense']) ? 1 : 0;
    $amount = $_POST['amount'];
    $accountId = $_POST['accountId'];
    $primaryCategoryId = $_POST['primaryCategoryId'];
    $secondaryCategoryId = $_POST['secondaryCategoryId'] ?? null;
    $description = $_POST['description'];

    updateTemplateTransaction($templateId, $templateName, $isExpense, $amount, $accountId, $primaryCategoryId, $secondaryCategoryId, $description);

    header("Location: ../../client/index.php");
    exit();
} else {
    echo "Metodo non valido.";
}
?>
