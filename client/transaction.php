<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../client/css/body-nav-foot.css">
    <link rel="stylesheet" href="../client/css/transaction.css">

    <title>Crea Transazione</title>
</head>

<body>
    <div id="innnerContent">
        <?php include '../server/functions.php';
        printNav(); ?>

        <div class="container">
            <div class="row">
                <div class="col-sm">
                    One of three columns
                </div>
                <div class="col-sm">
                    One of three columns
                </div>
                <div class="col-sm">
                    One of three columns
                </div>
            </div>
        </div>

        <hr>
        <div id="newTransaction">

            <h2 class="text-center" style="margin: 20px;">Crea una nuova transazione</h2>
            <div class="container mt-4">
                <form action="../server/create_transaction_s.php" method="post">
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="isEntrata" name="isEntrata">
                        <label class="custom-control-label" for="isEntrata">è un'entrata?</label>
                    </div>


                    <div class="form-group">
                        <label for="importo">Importo:</label>
                        <input type="number" step="0.01" name="importo" id="importo" required class="form-control"><br>
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
                        <select name="idCategoriaPrimaria" id="idCategoriaPrimaria" class="form-control" onchange="updateCategorieSecondarie(this.value)">
                            <?php $categoriePrimarie = getAllCategoriePrimarie();
                            foreach ($categoriePrimarie as $categoria) {
                                echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
                            } ?>
                        </select><br>
                    </div>

                    <div class="form-group">
                        <label for="idCategoriaSecondaria">ID Categoria Secondaria:</label>
                        <select name="idCategoriaSecondaria" id="idCategoriaSecondaria" class="form-control">
                            <option value="" selected>Seleziona una categoria secondaria</option>
                            <!-- Le opzioni verranno aggiunte qui tramite JavaScript -->
                        </select><br>
                    </div>

                    <div class="form-group">
                        <label for="descrizione">Descrizione:</label>
                        <textarea name="descrizione" id="descrizione" class="form-control"></textarea><br>
                    </div>

                    <button type="submit" class="btn" style="background-color: #36ad47; border-color: #36ad47; color: white;">Crea Transazione</button>
                </form>
            </div>
        </div>
        <hr>
        <br>
        <?php printFoot(); ?>
    </div>


    <script>
        function updateCategorieSecondarie(idCategoriaPrimaria) {
            const url = '../server/get_categorie_secondarie.php?idCategoriaPrimaria=' + idCategoriaPrimaria;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('idCategoriaSecondaria');
                    select.innerHTML = '<option value="" selected>Seleziona una categoria secondaria</option>';
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