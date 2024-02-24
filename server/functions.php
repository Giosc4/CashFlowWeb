<?php
require_once '../db/db.php';
require_once '../db/read_db.php';
require_once '../db/queries.php';
require_once '../server/classes.php';

function displayAllTables()
{
  $accounts = getAllAccounts();
  $transactions = getAllTransactions();
  $categoriePrimarie = getAllCategoriePrimarie();
  $categorieSecondarie = getAllCategorieSecondarie();
  // Aggiungi qui altre chiamate di funzione

  displayTableData($accounts, 'account');
  displayTableData($transactions, 'transaction');
  displayTableData($categoriePrimarie, 'categoria primaria');
  displayTableData($categorieSecondarie, 'categoria secondaria');
  // Aggiungi qui altre chiamate a displayTableData
}

// Funzione per visualizzare i dati di una tabella
function displayTableData($data, $tableName)
{
  echo "<h3>$tableName</h3>";

  if (!empty($data)) {
    echo "<table border='1'>";
    echo "<tr>";

    // Stampa gli header della tabella
    foreach ($data[0] as $key => $value) {
      echo "<th>$key</th>";
    }

    echo "</tr>";

    // Stampa i dati della tabella
    foreach ($data as $row) {
      echo "<tr>";
      foreach ($row as $value) {
        echo "<td>$value</td>";
      }
      echo "</tr>";
    }

    echo "</table>";
  } else {
    echo "Nessun dato presente nella tabella $tableName.";
  }
}

function displayAccounts()
{
  $accounts = getAllAccounts();
  $count = 0;

  foreach ($accounts as $account) {
    if ($count % 4 == 0) {
      echo "<div class='row justify-content-center'>";
    }

    echo "<div class='col-md-3'>"; // Dividi la larghezza della colonna in 4 parti (12 / 4 = 3)
    echo "<div class='card mb-3'>";
    echo "<div class='card-body btn'>";
    echo "<h5 class='card-title'>{$account['Nome_Account']}</h5>";
    echo "<p class='card-text'>Saldo: {$account['Saldo']}</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    // Incrementa il contatore
    $count++;

    // Se il contatore è divisibile per 4 o siamo all'ultimo account, chiudi la riga
    if ($count % 4 == 0 || $count == count($accounts)) {
      echo "</div>"; // Chiudi la riga
    }
  }
}


function displayAccountsDetails()
{

  $accounts = getAllAccounts();
  $count = 0;

  foreach ($accounts as $account) {
    if ($count % 3 == 0) {
      echo "<div class='row justify-content-center'>";
    }

    echo "<div class='col-md-4' >";
    echo "<div class='card mb-3 box-accounts'>";
    echo "<div class='card-body btn details-accounts'>";
    echo "<h5 class='card-title titolo'>{$account['Nome_Account']}</h5>";
    echo "<p class='card-text'>Saldo: {$account['Saldo']}</p>";
    echo "<p class='card-text'>IdAccount: {$account['IdAccount']}</p>";
    echo "<a href='../client/risparmi.php' class='btn btn-primary accountsDetails-btn' style='background-color: #36ad47;'>Risparmi</a>";
    echo "<br><a href='../client/transactions.php' class='btn btn-primary accountsDetails-btn' style='background-color: #36ad47;'>Transazioni</a>";
    echo "<br><a href='../client/budget_obiettivi.php' class='btn btn-primary accountsDetails-btn' style='background-color: #36ad47;'>Budget e Obiettivi</a>";
    echo "<br><a href='../client/debito_credito.php' class='btn btn-primary accountsDetails-btn' style='background-color: #36ad47;'>Credito / Debito</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    // Incrementa il contatore
    $count++;

    // Se il contatore è divisibile per 4 o siamo all'ultimo account, chiudi la riga
    if ($count % 3 == 0 || $count == count($accounts)) {
      echo "</div>"; // Chiudi la riga
    }
  }
}










function displayTransactionsList()
{
  $transactions = getAllTransactions();
  echo "<thead>
                <tr>
                    <th class='centered-cell'>Data Transazione</th>
                    <th class='centered-cell'>Descrizione</th>
                    <th class='centered-cell'>Entrata</th>
                    <th class='centered-cell'>Importo</th>
                    <th class='centered-cell'>Utente ID</th>
                </tr>
            </thead>
            <tbody>";

  foreach ($transactions as $transaction) {
    if ($transaction['IsEntrata'] == 1) {
      $IsEntry = "Si";
    } else {
      $IsEntry = "No";
    }
    echo "<tr>
                <td class='centered-cell'>{$transaction['DataTransazione']}</td>
                <td class='centered-cell'>{$transaction['Descrizione']}</td>
                <td class='centered-cell'>{$IsEntry}</td>
                <td class='centered-cell'>{$transaction['Importo']}</td>
                <td class='centered-cell'>{$transaction['IDAccount']}</td>
              </tr>";
  }

  echo "</tbody>";
}


function displayLineChart()
{
  echo "<canvas id='lineChart' width='400' height='400'></canvas>";
  $labels = ["Gennaio", "Febbraio", "Marzo", "Aprile"];
  $data = [10, 20, 30, 40];
  echo "
    <script>
var ctx = document.getElementById('lineChart').getContext('2d'); // Corretto per corrispondere all'ID del canvas
var chartData = {
  labels: " . json_encode($labels) . ",
  datasets: [{
    label: 'Vendite',
    data: " . json_encode($data) . ",
    backgroundColor: 'rgba(0, 119, 204, 0.3)'
  }]
};

var myChart = new Chart(ctx, {
  type: 'line',
  data: chartData
});
</script>
";
}


function displayPieChart()
{
  echo "<canvas id='pieChart' width='400' height='400'></canvas>";
  $labels = ["Categoria 1", "Categoria 2", "Categoria 3", "Categoria 4"];
  $data = [25, 15, 30, 30]; // Assicurati che i valori sommino fino a 100 se vuoi che rappresentino una percentuale
  echo "
    <script>
var ctx = document.getElementById('pieChart').getContext('2d');
var pieData = {
  labels: " . json_encode($labels) . ",
  datasets: [{
    data: " . json_encode($data) . ",
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)'
    ],
    borderWidth: 1
  }]
};

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: pieData
});
</script>
";
}

function displayBarChart()
{
  echo "<canvas id='barChart' width='400' height='400'></canvas>";
  $labels = ["Gennaio", "Febbraio", "Marzo", "Aprile"];
  $data = [20, 30, 40, 50];
  echo "
    <script>
var ctx = document.getElementById('barChart').getContext('2d');
var barData = {
  labels: " . json_encode($labels) . ",
  datasets: [{
    label: 'Vendite',
    data: " . json_encode($data) . ",
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)'
    ],
    borderWidth: 1
  }]
};

var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: barData,
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>
";
}

function printNav()
{
  echo "<nav class='navbar navbar-expand-lg navbar-light bg-light'>
  <a class='navbar-brand' href='../client/'> <img src='../INFO/CashFlowApp_LOGO-bordo.png' alt='LOGO' width='100px' id='logo'> </a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>
  <div class='collapse navbar-collapse' id='navbarNav'>
    <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link active navWord' aria-current='page' href='accounts.php'>Account</a>
            </li>
            <li class='nav-item '>
                <a class='nav-link active navWord' href='transaction.php'>Transazioni</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link active navWord' href='budget_obiettivi.php'>Budget/Obiettivi</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link active navWord' href='debito_credito.php'>Debito/Credito</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link active navWord' href='categories.php'>Categorie</a>
            </li>
        </ul>
    </div>
</nav>";
}


function printFoot()
{
  echo "<footer class='footer mt-auto py-3 bg-light'>
    <div class='container'>
        <span class='text-muted text-center'>CashFlow Web by Giovanni Maria Savoca</span>
    </div>
</footer>";
}
