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
    <title>Create Obiettivo</title>
</head>

<body>
    <form action="C:/Users/giova/xampp/htdocs/CashFlowWeb/server/creazione/new_obiettivo_server.php" method="post">

        <label for="obiettivoName">Name:</label>
        <input type="text" id="obiettivoName" name="obiettivoName" required><br>

        <label for="obiettivoAmount">Obiettivo Amount:</label>
        <input type="number" id="obiettivoAmount" name="obiettivoAmount" step="0.01" autocomplete="off" required><br>

        <label for="obiettivoDateInizio">Start Date:</label>
        <input type="date" id="obiettivoDateInizio" name="obiettivoDateInizio" value="<?php echo date("Y-m-d"); ?>" required><br>

        <?php
       require_once '../../db/read_functions.php';
       global $selectContoFromEmail;
       $conti = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        ?>
        <label for="contoId">Select an Account:</label>
        <select name="contoId" required>
            <option value="" disabled selected>Please select an Account</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['ID']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Create Obiettivo">

    </form>
</body>

</html>