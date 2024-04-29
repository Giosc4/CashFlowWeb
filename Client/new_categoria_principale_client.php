<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CategoriaPrimaria</title>
</head>

<body>
    <form action="../server/new_categoria_principale_server.php" method="post">
        <label for="categoryName">Categoria Primaria Nome:</label><br>
        <input type="text" id="categoryName" name="categoryName" required autocomplete="off"><br>
        <input type="submit" value="Create Category">
    </form>
</body>

</html>