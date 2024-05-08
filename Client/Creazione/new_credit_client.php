<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location:  /client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Credito</title>
</head>

<body>

    <form action=" ../../server/creazione/new_credit_server.php" method="post">

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
        require '../../db/read_functions.php';
        global $selectContoFromEmail;
        $conti = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
        ?>
        <select name="contoId" required>
            <option value="" disabled selected>Please seleziona un Conto</option>
            <?php foreach ($conti as $conto) : ?>
                <option value="<?php echo $conto['ID']; ?>"><?php echo $conto['NomeConto']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoriaPrimaria">Seleziona Categoria Primaria:</label>
        <?php
        require '../../db/read_functions.php';
        $primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);
        ?>
        <select name="categoriaPrimariaId" required>
            <option value="" disabled selected>Seleziona una Categoria</option>
            <?php foreach ($primaryCategories as $categoria) : ?>
                <option value="<?php echo $categoria['ID']; ?>"><?php echo $categoria['NomeCategoria']; ?></option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="description">Descrizione:</label>
        <input type="text" id="description" name="description"><br>

        <input type="submit" value="Crea Credito">


    </form>
</body>

</html>