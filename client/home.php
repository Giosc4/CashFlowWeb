<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Home</title>

    <style>
        body {
            padding-top: 20px;
            padding-right: 250px;
            padding-left: 250px;
            background-color: #6cd45d;
        }

        #innnerContent {
            background-color: white;
            border-radius: 15px;
            padding: 10px;
        }

        .footer {
            background-color: #f8f9fa;
            text-align: center;
            margin-top: 10px;
            padding: 10px;
        }

        #tot {
            font-size: 23px;
            font-weight: bold;
            padding: 20px;
        }

        .navWord {
            margin-left: 50px;
            font-weight: bold;
            font-size: 30px;
        }

        #accounts {
            margin-top: 20px;
            border-radius: 15px;
        }

        #bottoneAccount {
            padding: 10px;
            border-color: #36ad47;
            border-width: 5px;
            color: #36ad47;
            border-radius: 15px;
        }

        .transactions-box {
            margin-top: 2px;
            margin-left: 20px;
            border-radius: 15px;

        }
    </style>
</head>

<body>
    <div id="innnerContent">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><img src="../INFO/CashFlowApp LOGO.png" alt="LOGO" width="100px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav " id="navWords">
                    <li class="nav-item">
                        <a class="nav-link active navWord" aria-current="page" href="#">Account</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active navWord" href="transaction.php">Transazioni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active navWord" href="statistics.php">Dati Statistici</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container text-center" id="accounts">
            <?php
            include '../server/functions.php';
            displayAccounts();
            ?>
        </div>

        <div>
            <h1 class="text-C" id="tot">TOTALE: </h1>
        </div>

        <div class="container mt-4">
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_date">Data di inizio</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_date">Data di fine</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                </div>
                <button type="submit" class="btn" style="background-color: #36ad47; border-color: #36ad47; color: white;">Visualizza</button>
            </form>
        </div>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Lista Transazioni</h5>
                            <?php displayTransactionsList(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Flusso di Cassa</h5>
                            <!-- Inserisci qui il tuo grafico -->
                            <?php displayLineChart(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Torta Categorie</h5>
                            <!-- Inserisci qui il tuo grafico -->
                            <?php displayPieChart(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Barre sulle Categorie</h5>
                            <!-- Inserisci qui il tuo grafico -->
                            <?php displayBarChart(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class="footer">
            <p class="text-center">CashFlow Web by Giovanni Maria Savoca</p>
        </footer>

    </div>
</body>

</html>