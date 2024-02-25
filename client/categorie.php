<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../client/css/body-nav-foot.css">
    <link rel="stylesheet" href="../client/css/categorie.css">
    <title>Categorie</title>
</head>

<body>
    <div id="innnerContent">

        <?php include '../server/functions.php';
        printNav(); ?>
        <div class="container" style="margin-top: 30px;">

            <div class="row justify-content-center">

                <a href="#" class="btn btn-primary creaCategoria-btn">Crea Categoria Principale</a>
                <a href="#" class="btn btn-primary creaCategoria-btn">Crea Categoria Secondaria</a>
            </div>
            <hr>
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
            <hr>
        </div>

        <?php printFoot();
        ?>
    </div>
    </div>
</body>

</html>