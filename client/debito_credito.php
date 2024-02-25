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
    <title>Debito Credito</title>
</head>

<body>
    <div id="innnerContent">

        <?php include '../server/functions.php';
        printNav(); ?>

        <div class="container my-5">
            <!-- Primo Contenitore -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2>Lista Debiti</h2>
                </div>
                <div class="col-md-7 griglia">
                    <table class="tabella">
                        <tr class="testo">
                            <th>Id Categoria</th>
                            <th>Importo Massimo</th>
                            <th>Importo Speso</th>
                        </tr>
                        <tr class="testo">
                            <td>Categoria 1</td>
                            <td>Importo Massimo 1</td>
                            <td>Importo Speso 1</td>
                        </tr>
                        <tr class="testo">
                            <td>Categoria 2</td>
                            <td>Importo Massimo 2</td>
                            <td>Importo Speso 2</td>
                        </tr>
                        <tr class="testo">
                            <td>Categoria 3</td>
                            <td>Importo Massimo 3</td>
                            <td>Importo Speso 3</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3 d-flex align-items-center ">
                    <button class="btn btn-primary btn-block creaButton ">Crea Debito</button>
                </div>
            </div>
            <hr>
            <!-- Secondo Contenitore -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2>Lista Crediti</h2>
                </div>
                <div class="col-md-7 griglia">
                    <table class="tabella">
                        <tr class="testo">
                            <th>Id Account</th>
                            <th>Importo Massimo</th>
                            <th>Importo Attuale</th>
                            <th>Data</th>
                            <th>Descrizione</th>
                        </tr>
                        <tr class="testo">
                            <td>Account 1</td>
                            <td>Importo Massimo 1</td>
                            <td>Importo Attuale 1</td>
                            <td>Data 1</td>
                            <td>Descrizione 1</td>
                        </tr>
                        <tr class="testo">
                            <td>Account 2</td>
                            <td>Importo Massimo 2</td>
                            <td>Importo Attuale 2</td>
                            <td>Data 2</td>
                            <td>Descrizione 2</td>
                        </tr>
                        <tr class="testo">
                            <td>Account 3</td>
                            <td>Importo Massimo 3</td>
                            <td>Importo Attuale 3</td>
                            <td>Data 3</td>
                            <td>Descrizione 3</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button class="btn btn-primary btn-block creaButton">Crea Credito</button>
                </div>
            </div>
        </div>


        <?php printFoot();
        ?>
    </div>
</body>

</html>