<?php
session_start();

// Ensure the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';



// Get saving ID from query parameters
$risparmioId = $_GET['id'] ?? null;

// Fetch the saving details from the database using the saving ID
$risparmio = $risparmioId ? getSavingFromID($risparmioId) : null;

// Check if saving exists
if (!$risparmio) {
    echo "Saving not found.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}

// Assuming accounts are also related to user email, similar to the transaction case
$conti = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Risparmio</title>
</head>

<body>
    <h1>Modifica Risparmio</h1>
    <?php if ($risparmio) : ?>
        <form action="../../server/modifica/edit_saving_server.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($risparmio['ID']); ?>">

            <div>
                <label for="amount">Importo:</label>
                <input type="number" id="amount" name="amount" step="0.01" autocomplete="off" value="<?php echo htmlspecialchars($risparmio['ImportoRisparmiato']); ?>" required><br>
            </div>

            <div>
                <label for="risparmioDateInizio">Data Inizio Risparmio:</label>
                <input type="date" id="risparmioDateInizio" name="risparmioDateInizio" value="<?php echo htmlspecialchars($risparmio['DataInizio']); ?>" required><br>
            </div>

            <div>
                <label for="risparmioDateFine">Data Fine Risparmio:</label>
                <input type="date" id="risparmioDateFine" name="risparmioDateFine" value="<?php echo htmlspecialchars($risparmio['DataFine']); ?>" required><br>
            </div>

            <div>
                <label for="contoId">Seleziona un Conto:</label>
                <select name="contoId" required>
                    <?php foreach ($conti as $conto) : ?>
                        <option value="<?php echo htmlspecialchars($conto['ID']); ?>" <?php if ($conto['ID'] === $risparmio['IDConto']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($conto['NomeConto']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <button type="submit">Salva Modifiche</button>
        </form>

        <form action="../../server/eliminazione/delete_saving.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($risparmio['ID']); ?>">
            <button type="submit" style="background-color: red; color: white;">Elimina Risparmio</button>
        </form>
    <?php else : ?>
        <p>Saving not found.</p>
    <?php endif; ?>
</body>

</html>