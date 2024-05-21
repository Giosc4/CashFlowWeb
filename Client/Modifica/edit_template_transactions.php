<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';

$templateId = $_GET['id'] ?? null;
if (!$templateId) {
    echo "Nessun template specificato.";
    exit();
}

$templateData = getTemplateTransactionFromID($templateId);

if (!$templateData) {
    echo "Template transazione non trovato.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}

// Carica le opzioni per conti, categorie primarie e secondarie
global $selectContoFromEmail, $selectCategoriaPrimariaFromEmail;
$accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
$primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
$secondaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaSecondariaFromEmail);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Template Transazione</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include '../navbar.php'; ?> <br><br>

    <h1>Modifica Template Transazione</h1>
    <form action="../../server/modifica/edit_template_transaction_server.php" method="post">
        <input type="hidden" name="templateId" value="<?php echo htmlspecialchars($templateId); ?>">

        <label for="templateName">Nome del Template:</label>
        <input type="text" id="templateName" name="templateName" value="<?php echo htmlspecialchars($templateData['NomeTemplate']); ?>" required><br>

        <label for="isExpense">è una spesa:</label>
        <input type="checkbox" id="isExpense" name="isExpense" <?php if ($templateData['Is_Expense']) echo 'checked'; ?>><br>

        <label for="amount">Importo:</label>
        <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($templateData['Importo']); ?>" step="0.01" required><br>

        <label for="accountId">Seleziona un Conto:</label>
        <select id="accountId" name="accountId" required>
            <option value="" disabled>Seleziona un Conto</option>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['ID']; ?>" <?php echo ($account['ID'] == $templateData['IDConto']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($account['NomeConto']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="primaryCategoryId">Seleziona una Categoria Primaria:</label>
        <select id="primaryCategoryId" name="primaryCategoryId" required onchange="updateSecondaryCategories();">
            <option value="" disabled>Seleziona una Categoria Primaria</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>" <?php echo ($category['ID'] == $templateData['IDCategoriaPrimaria']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['NomeCategoria']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="secondaryCategoryId">Seleziona una Categoria Secondaria:</label>
        <select id="secondaryCategoryId" name="secondaryCategoryId">
            <option value="" disabled>Seleziona una Categoria Secondaria</option>
            <?php foreach ($secondaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>" data-primary-id="<?php echo $category['IDCategoriaPrimaria']; ?>" <?php echo ($category['ID'] == $templateData['IDCategoriaSecondaria']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['NomeCategoria']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="description">Descrizione:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($templateData['Descrizione']); ?></textarea><br>

        <input type="submit" value="Aggiorna Transazione">
    </form>

    <form action="../../server/eliminazione/delete_template_transactions.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($templateData['ID']); ?>">
        <button type="submit" style="background-color: red; color: white;">Elimina Template Transazione</button>
    </form>

    <script>
        function updateSecondaryCategories() {
            var primaryCategoryId = $('#primaryCategoryId').val();
            console.log("Primary Category ID: ", primaryCategoryId); // Debugging line

            $.ajax({
                url: '../../server/get_secondary_categories.php', // Correct path
                type: 'GET',
                data: {
                    primaryCategoryId: primaryCategoryId
                },
                dataType: 'json',
                success: function(categories) {
                    console.log("Received Categories:", categories); // Debugging line
                    var $secondarySelect = $('#secondaryCategoryId');
                    var selectedSecondaryCategoryId = "<?php echo $templateData['IDCategoriaSecondaria']; ?>";
                    $secondarySelect.empty(); // Remove old options
                    $secondarySelect.append('<option disabled selected>Per favore Seleziona la Categoria Secondaria</option>');
                    categories.forEach(function(category) {
                        var $option = $('<option>', {
                            value: category.ID,
                            text: category.NomeCategoria
                        });
                        if (category.ID == selectedSecondaryCategoryId) {
                            $option.attr('selected', 'selected');
                        }
                        $secondarySelect.append($option);
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText); // Debugging line
                }
            });
        }

        // Call the function once to initialize the secondary categories based on the current primary category
        $(document).ready(function() {
            updateSecondaryCategories();
        });
    </script>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>