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
    <title>Create Risparmio</title>
</head>

<body>
    <form action="/CashFlowWeb/server/creazione/new_risparmio_server.php" method="post">

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" required><br>

        <label for="risparmioDateInizio">Data Inizio Risparmio:</label>
        <input type="date" id="risparmioDateInizio" name="risparmioDateInizio" value="<?php echo date("Y-m-d"); ?>" required><br>

        <label for="risparmioDateFine">Data Fine Risparmio:</label>
        <input type="date" id="risparmioDateFine" name="risparmioDateFine" value="<?php echo date("Y-m-d"); ?>" required><br>

        <?php
        require '../../db/read_functions.php';
        global $selectContoFromEmail;
        $conti = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        ?>
        <label for="contoId">Seleziona un Conto:</label>
        <select name="contoId" required>
            <option value="" disabled selected>Please seleziona un Conto</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['ID']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Crea Risparmio">

    </form>
</body>

</html>