<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../client/css/body-nav-foot.css">
    <link rel="stylesheet" href="../client/css/transaction.css">

    <title>Crea Transazione</title>
</head>

<body>
    <div id="innnerContent">
        <?php include '../server/functions.php';
        printNav(); ?>

        <form action="../server/transaction_s.php" method="post">
            <div class="template-grid">
                <h2 id="template-h">Templates:</h2>
                <?php generaGrid(); ?>

            </div>
            <hr>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card box-transactions">
                            <div class="card-body">
                                <h5 class="card-title text-center">Lista Transazioni</h5>
                                <div class='scrollable-table'>

                                    <table class="table table-striped" style="font-size: 18px;">
                                        <thead>
                                            <tr>
                                                <th class='text-center align-middle'>Data Transazione</th>
                                                <th class='text-center align-middle'>Descrizione</th>
                                                <th class='text-center align-middle'>Entrata</th>
                                                <th class='text-center align-middle'>Importo</th>
                                                <th class='text-center align-middle'>Account ID</th>
                                                <th class='text-center align-middle'>Elimina Account</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php displayTransactionsList(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <hr>
            <div class="container-fluid" style="margin-top: 100px;">
                <div class="row">
                    <!-- Colonna principale a sinistra -->

                    <div class="col-md-7">
                        <div id="newTransaction">
                            <h2 class="text-center" style="margin: 10px;">Crea una nuova transazione</h2>
                            <div class="container mt-4">
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="isEntrata" name="isEntrata" value="1">
                                    <label class="custom-control-label" for="isEntrata">è un'entrata?</label>
                                </div>
                                <div class="form-group">
                                    <label for="importo">Importo:</label>
                                    <input type="number" step="0.01" name="importo" id="importo" required class="form-control">
                                </div>


                                <div class="form-group">
                                    <label for="idAccount">ID Account:</label>
                                    <select name="idAccount" id="idAccount" required class="form-control">
                                        <?php
                                        $accounts = getAllAccounts();
                                        foreach ($accounts as $account) {
                                            echo "<option value='{$account['IdAccount']}'>{$account['Nome_Account']}</option>";
                                        }
                                        ?>
                                    </select><br>
                                </div>

                                <div class="form-group">
                                    <label for="dataTransazione">Data Transazione:</label>
                                    <input type="date" name="dataTransazione" id="dataTransazione" value="<?= date('Y-m-d'); ?>" required class="form-control"><br>
                                </div>


                                <div class="form-group">
                                    <label for="idCategoriaPrimaria">ID Categoria Primaria:</label>
                                    <select name="idCategoriaPrimaria" id="idCategoriaPrimaria" class="form-control" onchange="updateCategorieSecondarie(this.value) " required>
                                        <?php $categoriePrimarie = getAllCategoriePrimarie();
                                        echo '<option value="" selected disabled>Seleziona una categoria secondaria</option>';
                                        foreach ($categoriePrimarie as $categoria) {
                                            echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
                                        } ?>
                                    </select><br>
                                </div>

                                <div class="form-group">
                                    <label for="idCategoriaSecondaria">ID Categoria Secondaria:</label>
                                    <select name="idCategoriaSecondaria" id="idCategoriaSecondaria" class="form-control">
                                        <option value="" selected disabled>Seleziona una categoria secondaria</option>
                                        <!-- Le opzioni verranno aggiunte qui tramite JavaScript -->
                                    </select><br>
                                </div>

                                <div class="form-group">
                                    <label for="descrizione">Descrizione:</label>
                                    <textarea name="descrizione" id="descrizione" class="form-control"></textarea><br>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                    <!-- Colonna di destra divisa in due parti -->
                    <div class="col-md-3" style=" display: flex; justify-content: center;  align-items: center;">

                        <div class="row align-items-center ">
                            <div class="col-14" id="ripTempl">
                                <h2 class="text-center" style="margin: 10px;">Crea una ripetizione</h2>
                                <div class="form-group">

                                    <!-- Sezione superiore destra: Label e tendina -->
                                    <label for="selectExample">Seleziona un'opzione:</label>
                                    <select id="selectExample" class="form-control">
                                        <option value="" selected>Seleziona un'opzione</option>
                                        <option value="1">Opzione 1</option>
                                        <option value="2">Opzione 2</option>
                                        <option value="3">Opzione 3</option>
                                        <option value="4">Opzione 4</option>
                                    </select>
                                </div>
                                <div class="form-group">

                                    <label for="dateExample">Seleziona una data:</label>
                                    <input type="date" id="dateExample" class="form-control">
                                </div>
                            </div>
                            <div class="col-14" id="ripTempl">
                                <h2 class="text-center" style="margin: 10px;">Crea una Template</h2>
                                <div class="form-group">
                                    <div class="custom-control custom-switch mb-3">
                                        <input type="checkbox" class="form-control   custom-control-input" id="isTemplate" name="newTemplate">
                                        <label class="custom-control-label" for="isTemplate">Crea un Template</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="custom-control custom-switch mb-3">
                        <button type="submit" name="submit" class="btn" id="button-newTransaction" value="createTransaction" >Crea Transazione</button>

                    </div>
                </div>
                <br>

            </div>
        </form>
        <?php printFoot(); ?>
    </div>


    <script>
        function updateCategorieSecondarie(idCategoriaPrimaria) {
            const url = '../server/get_categorie_secondarie.php?idCategoriaPrimaria=' + idCategoriaPrimaria;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('idCategoriaSecondaria');
                    select.innerHTML = '<option value="" selected disabled>Seleziona una categoria secondaria</option>';
                    data.forEach(categoria => {
                        const option = new Option(categoria.NomeCategoria, categoria.ID);
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Errore:', error));
        }
    </script>
</body>

</html>