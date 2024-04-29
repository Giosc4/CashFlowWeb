<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Risparmio</title>
</head>

<body>
    <form action="new_risparmio_server.php" method="post">

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="risparmioDateInizio">Data Inizio Risparmio:</label>
        <input type="date" id="risparmioDateInizio" name="risparmioDateInizio" value="<?php echo date("Y-m-d"); ?>" required><br>

        <label for="risparmioDateFine">Data Fine Risparmio:</label>
        <input type="date" id="risparmioDateFine" name="risparmioDateFine" value="<?php echo date("Y-m-d"); ?>" required><br>

        <label for="contoId">Seleziona un Conto:</label>
        <select name="contoId" required>
            <option value="" disabled selected>Please seleziona un Conto</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto->id; ?>"><?php echo $conto->name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Crea Risparmio">

    </form>
</body>

</html>