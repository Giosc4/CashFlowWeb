<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Obiettivo</title>
</head>

<body>
    <form action="../server/new_obiettivo_server.php" method="post">

        <label for="obiettivoName">Name:</label>
        <input type="text" id="obiettivoName" name="obiettivoName" required><br>

        <label for="obiettivoAmount">Obiettivo Amount:</label>
        <input type="number" id="obiettivoAmount" name="obiettivoAmount" step="0.01" autocomplete="off" required><br>

        <label for="obiettivoDateInizio">Start Date:</label>
        <input type="date" id="obiettivoDateInizio" name="obiettivoDateInizio" value="<?php echo date("Y-m-d"); ?>" required><br>

        <?php
        include '../db/read_functions.php';
        $conti = getAllConti();
        ?>
        <label for="contoId">Select an Account:</label>
        <select name="contoId" required>
            <option value="" disabled selected>Please select an Account</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['IDConto']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Create Obiettivo">

    </form>
</body>

</html>
