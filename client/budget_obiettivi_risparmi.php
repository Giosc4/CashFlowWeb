<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../client/css/body-nav-foot.css">
    <link rel="stylesheet" href="../client/css/BOR.css">

    <title>Budget Obiettivi Risparmi</title>
</head>

<body>
    <div id="innnerContent">

        <?php include '../server/functions.php';
        printNav(); ?>
        <div class="container">
            <!-- Primo Contenitore -->
            <div class="row mb-4 contenitore-budget" >
                <div class="col-12">
                    <h2>Budget</h2>
                </div>
                <div class="col-md-7 griglia">
                    <div class="row justify-content-center">
                        <div class='scrollable-table'>
                            <table class="table table-striped" style="font-size: 18px;">
                                <thead>
                                    <tr>
                                        <th class='text-center align-middle'>NomeBudget</th>
                                        <th class='text-center align-middle'>IDCategoria</th>
                                        <th class='text-center align-middle'>ImportoMassimo</th>
                                        <th class='text-center align-middle'>Data Fine</th>
                                        <th class='text-center align-middle'>Data Inizio</th>
                                        <th class='text-center align-middle'>Elimina Budget</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php displayBudgetsList(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex  ">
                    <button class="btn btn-block creaButton ">Crea Budget</button>
                </div>
            </div>
            <hr>
            <!-- Secondo Contenitore -->
            <div class="row mb-4 contenitore-obiettivi">
                <div class="col-12">
                    <h2>Obiettivi</h2>
                </div>
                <div class="col-md-7 griglia">
                    <div class="row justify-content-center">
                        <div class='scrollable-table'>
                            <table class="table table-striped" style="font-size: 18px;">
                                <thead>
                                    <tr>
                                        <th class='text-center align-middle'>NomeObiettivo</th>
                                        <th class='text-center align-middle'>ImportoObiettivo</th>
                                        <th class='text-center align-middle'>DataScadenza</th>
                                        <th class='text-center align-middle'>Elimina Obiettivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php displayObiettiviList(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-text-center justify-content-center">
                    <button class="btn btn-block creaButton ">Crea Obiettivo</button>
                </div>
            </div>

            <hr>
            <!-- Terzo Contenitore -->
            <div class="row mb-4 contenitore-risparmi">
                <div class="col-12">
                    <h2>Risparmi</h2>
                </div>
                <div class="col-md-7 griglia">
                    <div class="row justify-content-center">
                        <div class='scrollable-table'>
                            <table class="table table-striped" style="font-size: 18px;">
                                <thead>
                                    <tr>
                                        <th class='text-center align-middle'>IDAccount</th>
                                        <th class='text-center align-middle'>Importo</th>
                                        <th class='text-center align-middle'>Data Inizio Risparmio</th>
                                        <th class='text-center align-middle'>Data Fine Risparmio</th>
                                        <th class='text-center align-middle'>Elimina Risparmio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php displayRisparmiList(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-text-center justify-content-center ">
                    <button class="btn creaButton">Crea Risparmio</button>
                </div>
            </div>


            <?php printFoot();
            ?>
        </div>
</body>

</html>