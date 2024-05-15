<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Generazione Report Finanziario</title>
</head>

<body>
    <h1>Generazione Report Finanziario</h1>
    <form action="/CashFlowWeb/server/exportData_server.php" method="POST">

        <label for="start_date">Data Inizio:</label>
        <input type="date" id="start_date" name="start_date"><br>

        <label for="end_date">Data Fine:</label>
        <input type="date" id="end_date" name="end_date"><br>

        <label for="transaction_type">Tipo Transazione:</label>
        <select id="transaction_type" name="transaction_type">
            <option value="-1">Tutte</option>
            <option value="0">Entrate</option>
            <option value="1">Uscite</option>
        </select><br>

        <?php
        require_once '../db/read_functions.php';
        global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail;
        $accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>
<label for="accountId">Seleziona un Conto:</label>
<select id="accountId" name="accountId">
    <option value="">Seleziona un Conto</option>
    <?php foreach ($accounts as $account) : ?>
        <option value="<?php echo $account['ID']; ?>"><?php echo $account['NomeConto']; ?></option>
    <?php endforeach; ?>
</select><br>

<label for="primaryCategoryId">Seleziona la Categoria Primaria:</label>
<select id="primaryCategoryId" name="primaryCategoryId" onchange="updateSecondaryCategories();">
    <option value="">Seleziona una Categoria Primaria</option>
    <?php foreach ($primaryCategories as $category) : ?>
        <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
    <?php endforeach; ?>
</select><br>

<label for="secondaryCategoryId">Seleziona la Categoria Secondaria:</label>
<select id="secondaryCategoryId" name="secondaryCategoryId">
    <option value="">Seleziona una Categoria</option>
</select><br>
        <input type="submit" value="Genera Report">
    </form>
    <script>
        function updateSecondaryCategories() {
            var primaryCategoryId = document.getElementById("primaryCategoryId").value;
            var secondaryCategorySelect = document.getElementById("secondaryCategoryId");
            secondaryCategorySelect.innerHTML = '<option value="" disabled selected>Seleziona la Categoria Secondaria</option>';

            if (primaryCategoryId) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "/CashFlowWeb/server/getSecondaryCategories.php?primaryCategoryId=" + primaryCategoryId, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var categories = JSON.parse(xhr.responseText);
                        categories.forEach(function(category) {
                            var option = document.createElement("option");
                            option.value = category.ID;
                            option.text = category.NomeCategoria;
                            secondaryCategorySelect.appendChild(option);
                        });
                    }
                };
                xhr.send();
            }
        }
    </script>

</body>

</html>