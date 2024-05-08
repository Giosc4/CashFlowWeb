<?php
session_start();

// Ensure the user is logged in
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



// Get debit ID from query parameters
$id = $_GET['id'] ?? null;

// Fetch the debit details from the database using the debit ID
$debit = $id ? getDebtFromID($id) : null;

global $selectContoFromEmail;
$accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);

// Check if debit exists
if (!$debit) {
    echo "debit not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit debit</title>
</head>

<body>
    <h1>Edit debit</h1>
    <?php if ($debit) : ?>
        <form action="../../server/modifica/edit_debit_server.php" method="post">
            <!-- Hidden field to send the debit ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($debit['ID']); ?>">

            <!-- Field to edit the debit amount -->
            <div>
                <label for="importoDebito">debit Amount:</label>
                <input type="number" id="importoDebito" name="ImportoDebito" value="<?php echo htmlspecialchars($debit['ImportoDebito']); ?>" step="0.01" required>
            </div>

            <!-- Field to edit the debit name -->
            <div>
                <label for="nomeImporto">debit Name:</label>
                <input type="text" id="nomeImporto" name="NomeImporto" value="<?php echo htmlspecialchars($debit['NomeImporto']); ?>" required>
            </div>

            <!-- Field to edit the concession date -->
            <div>
                <label for="dataConcessione">Concession Date:</label>
                <input type="date" id="dataConcessione" name="DataConcessione" value="<?php echo htmlspecialchars($debit['DataConcessione']); ?>" required>
            </div>

            <!-- Field to edit the extinction date -->
            <div>
                <label for="dataEstinsione">Extinction Date:</label>
                <input type="date" id="dataEstinsione" name="DataEstinsione" value="<?php echo htmlspecialchars($debit['DataEstinsione']); ?>" required>
            </div>

            <!-- Field to edit the notes -->
            <div>
                <label for="note">Notes:</label>
                <textarea id="note" name="Note"><?php echo htmlspecialchars($debit['Note']); ?></textarea>
            </div>

            <!-- Account Selection -->
            <div>
                <label for="IDConto">Select an Account:</label>
                <select id="IDConto" name="IDConto" required>
                    <?php foreach ($accounts as $account) : ?>
                        <option value="<?php echo htmlspecialchars($account['ID']); ?>" <?php if ($account['ID'] == $debit['IDConto']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($account['NomeConto']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <!-- Submit button to save changes -->
            <div>
                <button type="submit">Save Changes</button>
            </div>
        </form>
        <form action="../../server/eliminazione/delete_debit.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($debit['ID']); ?>">
            <button type="submit" style="background-color: red; color: white;">Elimina Debito</button>
        </form>
    <?php else : ?>
        <p>debit not found.</p>
    <?php endif; ?>
</body>

</html>