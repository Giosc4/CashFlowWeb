<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../client/css/accounts.css">
    <link rel="stylesheet" href="../client/css/body-nav-foot.css">

    <title>Crea Account</title>
</head>

<body>
    <div id="innnerContent">
        <?php include '../server/functions.php';
        printNav(); ?>
        <form action="../server/account_s.php" method="post">
            <?php
            displayAccountsDetails() ?>
        </form>
        <hr>
        <div class="container mt-5 text-center">
            <div class="col-md-6 mx-auto">
                <div class="card box-statistics">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: bold">Barre sulle Categorie</h5>
                        <!-- Inserisci qui il tuo grafico -->
                        <?php displayBarChart(); ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <!-- CREATE ACCOUNT -->
        <h2 class="text-center" style="margin: 20px;">Crea un nuovo account</h2>
        <div class="container mt-4">
            <form action="../server/account_s.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nomeAccount">Nome Account:</label>
                        <input type="text" class="form-control" id="nomeAccount" name="nomeAccount" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="saldo">Saldo:</label>
                        <input type="text" class="form-control" id="saldo" name="saldo" required>
                    </div>
                </div>
                <button type="submit" name="submit" value="createAccount" class="btn" id='bottone-crea'>Crea Account</button>
            </form>
        </div>

        <?php printFoot(); ?>
    </div>
</body>

</html>