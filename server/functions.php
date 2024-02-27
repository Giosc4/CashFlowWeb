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
  $html = "<h3>$tableName</h3>";

  if (!empty($data)) {
    $html .= "<table border='1'><tr>";
    // Stampa gli header della tabella
    foreach ($data[0] as $key => $value) {
      $html .= "<th>$key</th>";
    }
    $html .= "</tr>";

    // Stampa i dati della tabella
    foreach ($data as $row) {
      $html .= "<tr>";
      foreach ($row as $value) {
        $html .= "<td>$value</td>";
      }
      $html .= "</tr>";
    }
    $html .= "</table>";
  } else {
    $html .= "Nessun dato presente nella tabella $tableName.";
  }

  echo $html;
}


function displayAccounts()
{
  $accounts = getAllAccounts();
  if (empty($accounts)) {
    echo "<h3 class=' row justify-content-center'>Nessun account presente.</h3>";
  }
  $count = 0;
  $html = '';

  foreach ($accounts as $account) {
    if ($count % 3 == 0) {
      $html .= "<div class='row justify-content-center'>";
    }

    $html .= "<div class='col-md-3' style='margin:10px'>"; // Dividi la larghezza della colonna in 4 parti (12 / 4 = 3)
    $html .= "<div class='card mb-3 account-bordo'>";
    $html .= "<div class='card-body btn'>";
    $html .= "<h5 class='card-title'>{$account['Nome_Account']}</h5>";
    $html .= "<p class='card-text'>Saldo: {$account['Saldo']}</p>";
    $html .= "</div></div></div>";

    $count++;

    if ($count % 3 == 0 || $count == count($accounts)) {
      $html .= "</div>"; // Chiudi la riga
    }
  }

  echo $html;
}


function displayAccountsDetails()
{
  $accounts = getAllAccounts();
  if (empty($accounts)) {
    echo "<h3 class=' row justify-content-center'>Nessun account presente.</h3>";
  }
  $count = 0;
  $html = '';

  foreach ($accounts as $account) {
    if ($count % 3 == 0) {
      $html .= "<div class='row justify-content-center'>";
    }

    $html .= "<div class='col-md-3'>";
    $html .= "<div class='card mb-3 box-accounts'>";
    $html .= "<div class='card-body btn '>";
    $html .= "<h5 class='card-title titolo'>{$account['Nome_Account']}</h5>";
    $html .= "<p class='card-text'>Saldo: {$account['Saldo']}</p>";
    $html .= "<p class='card-text'>IdAccount: {$account['IdAccount']}</p>";
    $html .= "<br><button type='submit' class='btn btn-primary accountsDetails-btn' onclick=\"window.location='../client/transactions.php'\">Transazioni</button>";
    $html .= "<br><button type='submit' class='btn btn-primary accountsDetails-btn' onclick=\"window.location='../client/budget_obiettivi_risparmi.php'\">Budget e Obiettivi</button>";
    $html .= "<br><button type='submit' class='btn btn-primary accountsDetails-btn' onclick=\"window.location='../client/debito_credito.php'\">Credito / Debito</button>";
    $html .= "<form action='../server/account_s.php' method='post'>";
    $html .= "<input type='hidden' name='idAccount' value='{$account['IdAccount']}'>";
    $html .= "<hr><button type='submit' name='submit' value='deleteAccount' class='btn btn-danger' style='border-radius: 20px; padding: 10px;'>Elimina Account</button>";
    $html .= "</form>";
    $html .= "</div> </div> </div>";

    $count++;

    if ($count % 3 == 0 || $count == count($accounts)) {
      $html .= "</div>"; // Chiudi la riga
    }
  }

  echo $html;
}


function generaGrid()
{
  $elementi = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];

  $html = '<div class="container col-lg-9">'; // Apri il container

  // Iniziamo la prima riga
  $html .= '<div class="row">';

  foreach ($elementi as $indice => $elemento) {
    // Costruisci l'URL usando il nome dell'elemento con aggiunta l'estensione .php
    $url = strtolower($elemento) . '.php';

    // Aggiungi il box
    $html .= '<div class="col-lg-3 col-md-7 col-sm-7 mb-4" >';
    $html .= '<a  class="text-template" href="' . htmlspecialchars($url) . '" class="d-block h-100">';
    $html .= '<div class="card template-box">';
    $html .= '<div class="card-body text-center ">';
    $html .= "<div class='card-body btn'>";
    $html .= "<label class='card-title text-template'>" . htmlspecialchars($elemento) . "</label>";
    $html .= "</div>";
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</a>';
    $html .= '</div>';

    // Chiudi e apri una nuova riga ogni 4 elementi
    if (($indice + 1) % 4 == 0 && ($indice + 1) < count($elementi)) {
      $html .= '</div><div class="row">';
    }
  }

  // Chiudi l'ultima riga e il container
  $html .= '</div>';
  $html .= '</div>';

  echo $html;
}

function displayTransactionsList()
{
  $transactions = getAllTransactions();

  foreach ($transactions as $transaction) {
    if ($transaction['IsEntrata'] == 1) {
      $IsEntry = "Si";
    } else {
      $IsEntry = "No";
    }
    echo "<tr'> 
    <form action='../server/transaction_s.php' method='post'>

                <td class='text-center align-middle'>{$transaction['DataTransazione']}</td>
                <td class='text-center align-middle'>{$transaction['Descrizione']}</td>
                <td class='text-center align-middle'>{$IsEntry}</td>
                <td class='text-center align-middle'>{$transaction['Importo']}</td>
                <td class='text-center align-middle'>{$transaction['IDAccount']}</td>
                <td class='text-center align-middle'><input type='hidden' name='transaction_id' value='{$transaction['ID']}'>
                <button type='submit' name='submit' value='deleteTransaction' class='btn btn-danger' style='border-radius: 80px; font-size: 12px;'>Elimina</button></td>
                </tr> </form>";
  }
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
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>
";
}


function printNav()
{
  echo " <nav class='navbar navbar-expand-lg navbar-light bg-light'>
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
                <a class='nav-link active navWord' href='budget_obiettivi_risparmi.php'>B.O.R.</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link active navWord' href='debito_credito.php'>Debito/Credito</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link active navWord' href='categorie.php'>Categorie</a>
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
