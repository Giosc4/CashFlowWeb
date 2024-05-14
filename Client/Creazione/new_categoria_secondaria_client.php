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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="../../Server/creazione/new_categoria_secondaria_server.php" method="post">
        <label for="categoryName">Category Name:</label><br>
        <input type="text" id="categoryName" name="categoryName" required autocomplete="off"><br>
        <label for="categoryId">Seleziona un a Categoria Primaria:</label> <br>
        <?php
        require_once '../../db/read_functions.php';
        global  $selectCategoriaPrimariaFromEmail;
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);        ?>
        <select name="categoryId" required>
            <option value="" disabled selected>Per favore seleziona un a Categoria</option>
            <?php foreach ($primaryCategories as $category) : ?>
                <option value="<?php echo $category['ID']; ?>"><?php echo $category['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoryDescription">Descrizione Categoria:</label><br>
        <input type="text" id="categoryDescription" name="categoryDescription" autocomplete="off"><br>
        <br>

        <input type="submit" value="Create Category">
    </form>
</body>

</html>