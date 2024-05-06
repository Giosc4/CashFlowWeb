<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/read_functions.php';

// Ottieni l'ID della categoria primaria dalla query parameters
$categoryId = $_GET['id'] ?? null;

// Recupera i dettagli della categoria primaria dal database usando l'ID della categoria
$category = $categoryId ? getPrimaryCategoryById($categoryId) : null;

// Check se la categoria esiste
if (!$category) {
    echo "Categoria non trovata.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Categoria Primaria</title>
</head>

<body>
    <h1>Modifica Categoria Primaria</h1>
    <?php if ($category) : ?>
        <form action="../../Server/modifica/edit_categoria_primaria_server.php" method="POST">
            <!-- Campo nascosto per inviare l'ID della categoria -->
            <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($category['ID']); ?>">

            <!-- Campo per visualizzare il nome della categoria primaria -->
            <div>
                <label for="categoryName">Nome Categoria Primaria:</label><br>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['NomeCategoria']); ?>" required autocomplete="off"><br>
            </div>

            <!-- Campo per visualizzare la descrizione della categoria primaria -->
            <div>
                <label for="categoryDescription">Descrizione Categoria Primaria:</label><br>
                <textarea id="categoryDescription" name="categoryDescription"><?php echo htmlspecialchars($category['DescrizioneCategoria']); ?></textarea><br>
            </div>

            <!-- Pulsante per inviare le modifiche -->
            <input type="submit" value="Modifica Categoria">
        </form>

        <!-- Form to delete the transaction -->
        <form action="../../server/eliminazione/delete_primary_category.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['ID']); ?>">
            <button type="submit" style="background-color: red; color: white;">Cancella Categoria Primaria</button>
        </form>

    <?php else : ?>
        <p>Categoria non trovata.</p>
    <?php endif; ?>
</body>

</html>
