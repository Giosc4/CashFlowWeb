<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';



// Ottieni l'ID della categoria secondaria dalla query parameters
$categoryId = $_GET['id'] ?? null;

// Recupera i dettagli della categoria secondaria dal database usando l'ID della categoria
$category =  getSecondaryCategoryFromID($categoryId);

// Check se la categoria esiste
if (!$category) {
    echo "Secondary Category not found 1.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}


global   $selectCategoriaPrimariaFromEmail;
$primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Secondary Category</title>
</head>

<body>
    <h1>Edit Secondary Category</h1>
    <?php if ($category) : ?>
        <form action="../../server/modifica/edit_secondary_category_server.php" method="POST">

            <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($category['ID']); ?>">


            <div>
                <label for="categoryName">Category Name:</label><br>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['NomeCategoria']); ?>" required autocomplete="off"><br>
            </div>

            <div>
                <label for="primaryCategoryId">Primary Category:</label><br>
                <select id="primaryCategoryId" name="primaryCategoryId" required>
                    <option value="" disabled>Select a Primary Category</option>
                    <?php foreach ($primaryCategories as $primaryCategory) : ?>
                        <option value="<?php echo htmlspecialchars($primaryCategory['ID']); ?>" <?php if ($primaryCategory['ID'] == $category['IDCategoriaPrimaria']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($primaryCategory['NomeCategoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>
            <div>
                <label for="categoryDescription">Category Description:</label><br>
                <input type="text" id="categoryDescription" name="categoryDescription" value="<?php echo htmlspecialchars($category['DescrizioneCategoria']); ?>" autocomplete="off"><br>
            </div>

            <!-- Pulsante per inviare le modifiche -->
            <input type="submit" value="Save Changes">
        </form>

        <!-- Form per eliminare la categoria -->
        <form action="../../Server/eliminazione/delete_secondary_category.php" method="POST">
            <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($category['ID']); ?>">
            <button type="submit" style="background-color: red; color: white;">Delete Category</button>
        </form>

    <?php else : ?>
        <p>Secondary Category not found 2.</p>
    <?php endif; ?>
</body>

</html>