<?php
require_once 'write_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : "";

    // Verifica che il nome della categoria non sia vuoto
    if (!empty($categoryName)) {
        // Chiamata alla funzione per creare una nuova categoria
        createCategory($categoryName);
        echo "Categoria creata con successo.";
        header("Location: index.php");
    } else {
        echo "Errore: Il nome della categoria non può essere vuoto.";
    }
}
?>

<form action="create_category.php" method="post">
    <label for="categoryName">Category Name:</label><br>
    <input type="text" id="categoryName" name="categoryName" required><br>
    <input type="submit" value="Create Category">
</form>