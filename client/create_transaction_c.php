<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../client/css/index.css">
    <title>Crea Transazione</title>
</head>

<body>
    <div id="innnerContent">
        <?php include 'nav&foot.php';
        printNav(); ?>

        <h2 class="text-center" style="margin: 20px;">Crea una nuova transazione</h2>
        <div class="container mt-4">
            <form action="../server/create_transaction_s.php" method="post">
            <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="isEntrata" name="isEntrata" value="1">
                        <label class="custom-control-label" for="isEntrata">Entrata / Uscita</label>                    </div>
                </div>

                <div class="form-group">
                    <label for="importo">Importo:</label>
                    <input type="number" step="0.01" name="importo" id="importo" required class="form-control"><br>
                </div>

                <div class="form-group">
                    <label for="idAccount">ID Account:</label>
                    <select name="idAccount" id="idAccount" required class="form-control">
                        <?php
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
                    <select name="idCategoriaPrimaria" id="idCategoriaPrimaria" class="form-control">
                        <?php
                        foreach ($categoriePrimarie as $categoria) {
                            echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
                        }
                        ?>
                    </select><br>
                </div>

                <div class="form-group">
                    <label for="idCategoriaSecondaria">ID Categoria Secondaria:</label>
                    <select name="idCategoriaSecondaria" id="idCategoriaSecondaria" class="form-control">
                        <option value="" selected>Seleziona una categoria secondaria</option>
                        <?php
                        foreach ($categorieSecondarie as $categoria) {
                            echo "<option value='{$categoria['ID']}'>{$categoria['NomeCategoria']}</option>";
                        }
                        ?>
                    </select><br>
                </div>

                <div class="form-group">
                    <label for="descrizione">Descrizione:</label>
                    <textarea name="descrizione" id="descrizione" class="form-control"></textarea><br>
                </div>

                <button type="submit" class="btn" style="background-color: #36ad47; border-color: #36ad47; color: white;">Crea Transazione</button>
            </form>
        </div>

        <br>
        <div class="text-center" style="margin: 20px;">
            <a href="../client/index.php" class="btn" style="background-color: #ffffe6; color: #36ad47; border-color: #36ad47; border-width: 2px; border-radius: 15px;">Ritorna ad Index</a>
        </div>

        <?php printFoot(); ?>
    </div>
</body>

</html>