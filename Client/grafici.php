<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}

require_once '../db/read_functions.php';

$accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
$primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
$secondaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaSecondariaFromEmail);
$transactions = getTableBYEmail($_SESSION['email'], $selectTransazioniFromEmail);

// Prepare data for charts
$accountNames = [];
$accountBalances = [];
foreach ($accounts as $account) {
    $accountNames[] = $account['NomeConto'];
    $accountBalances[] = $account['Saldo'];
}

$primaryCategoryNames = [];
$primaryCategoryExpenses = [];
$primaryCategoryIncomes = [];
foreach ($primaryCategories as $category) {
    $primaryCategoryNames[] = $category['NomeCategoria'];
    $primaryCategoryExpenses[] = array_sum(array_column(array_filter($transactions, function ($transaction) use ($category) {
        return $transaction['IDCategoriaPrimaria'] == $category['ID'] && $transaction['Is_Expense'] == 1;
    }), 'Importo'));
    $primaryCategoryIncomes[] = array_sum(array_column(array_filter($transactions, function ($transaction) use ($category) {
        return $transaction['IDCategoriaPrimaria'] == $category['ID'] && $transaction['Is_Expense'] == 0;
    }), 'Importo'));
}

$secondaryCategoryNames = [];
$secondaryCategoryExpenses = [];
$secondaryCategoryIncomes = [];
foreach ($secondaryCategories as $category) {
    $secondaryCategoryNames[] = $category['NomeCategoria'];
    $secondaryCategoryExpenses[] = array_sum(array_column(array_filter($transactions, function ($transaction) use ($category) {
        return $transaction['IDCategoriaSecondaria'] == $category['ID'] && $transaction['Is_Expense'] == 1;
    }), 'Importo'));
    $secondaryCategoryIncomes[] = array_sum(array_column(array_filter($transactions, function ($transaction) use ($category) {
        return $transaction['IDCategoriaSecondaria'] == $category['ID'] && $transaction['Is_Expense'] == 0;
    }), 'Importo'));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafici</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h2 {
            text-align: center;
        }

        canvas {
            display: block;
            margin: 40px auto;
            width: 1000px;
            height: 500px;
        }

        .description {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <?php require('navbar.php') ?>

    <div class="container">
        <h1>Grafici</h1>

        <h2>Saldo dei Conti</h2>
        <canvas id="accountsChart"></canvas>

        <h2>Transazioni per Categoria Primaria</h2>
        <canvas id="primaryCategoriesChart"></canvas>

        <h2>Transazioni per Categoria Secondaria</h2>
        <canvas id="secondaryCategoriesChart"></canvas>
    </div>

    <script>
        const accountsCtx = document.getElementById('accountsChart').getContext('2d');
        const primaryCategoriesCtx = document.getElementById('primaryCategoriesChart').getContext('2d');
        const secondaryCategoriesCtx = document.getElementById('secondaryCategoriesChart').getContext('2d');

        const accountsChart = new Chart(accountsCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($accountNames); ?>,
                datasets: [{
                    label: 'Saldo dei Conti',
                    data: <?php echo json_encode($accountBalances); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const primaryCategoriesChart = new Chart(primaryCategoriesCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($primaryCategoryNames); ?>,
                datasets: [{
                    label: 'Spese per Categoria Primaria',
                    data: <?php echo json_encode($primaryCategoryExpenses); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Entrate per Categoria Primaria',
                    data: <?php echo json_encode($primaryCategoryIncomes); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const secondaryCategoriesChart = new Chart(secondaryCategoriesCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($secondaryCategoryNames); ?>,
                datasets: [{
                    label: 'Spese per Categoria Secondaria',
                    data: <?php echo json_encode($secondaryCategoryExpenses); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Entrate per Categoria Secondaria',
                    data: <?php echo json_encode($secondaryCategoryIncomes); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>