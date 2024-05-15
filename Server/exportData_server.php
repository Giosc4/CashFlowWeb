<?php

require_once '../db/db_connection.php';

// Verifica se il metodo di richiesta è POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Raccolta dei dati dal modulo
    $startDate = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
    $endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $transactionType = isset($_POST['transaction_type']) ? (int)$_POST['transaction_type'] : -1;
    $accountId = !empty($_POST['accountId']) ? (int)$_POST['accountId'] : null;
    $primaryCategoryId = !empty($_POST['primaryCategoryId']) ? (int)$_POST['primaryCategoryId'] : null;
    $secondaryCategoryId = !empty($_POST['secondaryCategoryId']) ? (int)$_POST['secondaryCategoryId'] : null;

    // Preparazione della stored procedure
    $stmt = $conn->prepare("CALL GenerateFinancialReport(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiii", $startDate, $endDate, $transactionType, $accountId, $primaryCategoryId, $secondaryCategoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Creazione del file CSV
    $filename = "financial_report_" . date('Ymd') . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'Is_Expense', 'Importo', 'IDConto', 'DataTransazione', 'IDCategoriaPrimaria', 'IDCategoriaSecondaria'));

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}
