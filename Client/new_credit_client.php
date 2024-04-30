<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Credito</title>
</head>

<body>

    <form action="../Server/new_credit_server.php" method="post">

        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" required><br>

        <label for="amount">Valore:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="creditConcessioneDate">Data Concessione Credito:</label>
        <input type="date" id="creditConcessioneDate" name="creditConcessioneDate" value="<?php echo date("Y-m-d"); ?>" required><br>
        <label for="creditEstinsioneDate">Data Estinsione Credito:</label>
        <input type="date" id="creditEstinsioneDate" name="creditEstinsioneDate" value="<?php echo date("Y-m-d"); ?>" required><br>

        <label for="contoId">Seleziona un Conto:</label>
        <?php
        include '../db/read_functions.php';
        $conti = getAllConti();
        ?>
        <select name="contoId" required>
            <option value="" disabled selected>Please seleziona un Conto</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['IDConto']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="description">Descrizione:</label>
        <input type="text" id="description" name="description"><br>

        <input type="submit" value="Crea Credito">


    </form>
</body>

</html>