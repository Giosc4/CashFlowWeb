<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../client/css/body-nav-foot.css">
    <link rel="stylesheet" href="../client/css/debito_credito.css">
    <title>Debito Credito</title>
</head>

<body>
    <div id="innnerContent">

        <?php include '../server/functions.php';
        printNav(); ?>

        <div class="container my-5">
            <!-- Primo Contenitore -->
            <div class="row mb-4 contenitore-debito">
                <div class="col-12">
                    <h2>Debiti</h2>
                </div>
                <div class="col-md-7 griglia">
                    <div class="row justify-content-center">
                        <div class='scrollable-table'>
                            <table class="table table-striped" style="font-size: 18px;">
                                <thead>
                                    <tr>
                                        <th class='text-center align-middle'>NomeDebito</th>
                                        <th class='text-center align-middle'>Importo</th>
                                        <th class='text-center align-middle'>Data Estrinzione</th>
                                        <th class='text-center align-middle'>Note</th>
                                        <th class='text-center align-middle'>Data Concessione</th>
                                        <th class='text-center align-middle'>Elimina Debito</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php displayDebitiList(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-text-center justify-content-center">
                    <button class="btn btn-block creaButton ">Crea Debito</button>
                </div>
            </div>

            <hr>
            <!-- Secondo Contenitore -->
            <div class="row mb-4 contenitore-credito">
                <div class="col-12">
                    <h2>Crediti</h2>
                </div>
                <div class="col-md-7 griglia">
                    <div class="row justify-content-center">
                        <div class='scrollable-table'>
                            <table class="table table-striped" style="font-size: 18px;">
                                <thead>
                                    <tr>
                                        <th class='text-center align-middle'>ID</th>
                                        <th class='text-center align-middle'>Importo</th>
                                        <th class='text-center align-middle'>Data Estinzione</th>
                                        <th class='text-center align-middle'>Note</th>
                                        <th class='text-center align-middle'>Data Concessione</th>
                                        <th class='text-center align-middle'>Nome Credito</th>
                                        <th class='text-center align-middle'>Elimina Credito</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php displayCreditiList(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-text-center justify-content-center">
                    <button class="btn btn-block creaButton ">Crea Credito</button>
                </div>
            </div>


            <?php printFoot();
            ?>
        </div>
</body>

</html>