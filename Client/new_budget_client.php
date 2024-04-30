<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="../server/new_budget_server.php" method="post">

        <label for="budgetName">Nome Budget:</label>
        <input type="text" id="budgetName" name="budgetName" required><br>

        <label for="amount">Valore:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="budgetStartDate">Data Inizio Budget:</label>
        <input type="date" id="budgetStartDate" name="budgetStartDate" value="<?php echo date("Y-m-d"); ?>" required><br>
        <label for="budgetEndDate">Data Inizio Budget:</label>
        <input type="date" id="budgetEndDate" name="budgetEndDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <input type="submit" value="Crea Categoria">

    </form>
</body>

</html>