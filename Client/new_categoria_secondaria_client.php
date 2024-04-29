<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="../server/new_categoria_principale_server.php" method="post">
        <label for="categoryName">Category Name:</label><br>
        <input type="text" id="categoryName" name="categoryName" required autocomplete="off"><br>
        <label for="categoryId">Seleziona un a Categoria Primaria:</label>
        <select name="categoryId" required>
            <option value="" disabled selected>Please seleziona un a Categoria</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Create Category">
    </form>
</body>

</html>