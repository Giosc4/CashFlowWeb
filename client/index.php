<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../client/css/index.css">
    <title>Home</title>

</head>

<body>
    <div id="innnerContent">
    <?php include 'nav&foot.php';
    printNav();
    ?>

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
                            <table class="table table-striped">
                                <?php displayTransactionsList(); ?>
                            </table>
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

    <?php 
    printFoot();
    ?>


    </div>
</body>

</html>