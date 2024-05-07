<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require '../../db/read_functions.php';

// Get credit ID from query parameters
$id = $_GET['id'] ?? null;

// Fetch the credit details from the database using the credit ID
$credit = $id ? getCreditFromID($id) : null;

global $selectContoFromEmail;
$accounts = getTableBYEmail($_SESSION['email'], $selectContoFromEmail);

// Check if credit exists
if (!$credit) {
    echo "Credit not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Credit</title>
</head>

<body>
    <h1>Edit Credit</h1>
    <?php if ($credit) : ?>
        <form action="../../server/modifica/edit_credit_server.php" method="post">
            <!-- Hidden field to send the credit ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($credit['ID']); ?>">

            <!-- Field to edit the credit amount -->
            <div>
                <label for="importoCredito">Credit Amount:</label>
                <input type="number" id="importoCredito" name="ImportoCredito" value="<?php echo htmlspecialchars($credit['ImportoCredito']); ?>" step="0.01" required>
            </div>

            <!-- Field to edit the credit name -->
            <div>
                <label for="nomeCredito">Credit Name:</label>
                <input type="text" id="nomeCredito" name="NomeCredito" value="<?php echo htmlspecialchars($credit['NomeImporto']); ?>" required>
            </div>

            <!-- Field to edit the accreditation date -->
            <div>
                <label for="dataAccredito">Accreditation Date:</label>
                <input type="date" id="dataAccredito" name="DataAccredito" value="<?php echo htmlspecialchars($credit['DataConcessione']); ?>" required>
            </div>

            <div>
                <label for="dataEstinsione">Data Estinsione:</label>
                <input type="date" id="dataAccredito" name="DataAccredito" value="<?php echo htmlspecialchars($credit['DataEstinsione']); ?>" required>
            </div>

            <!-- Field to edit the notes -->
            <div>
                <label for="note">Notes:</label>
                <textarea id="note" name="Note"><?php echo htmlspecialchars($credit['Note']); ?></textarea>
            </div>

            <!-- Account Selection -->
            <div>
                <label for="IDConto">Select an Account:</label>
                <select id="IDConto" name="IDConto" required>
                    <?php foreach ($accounts as $account) : ?>
                        <option value="<?php echo htmlspecialchars($account['ID']); ?>" <?php if ($account['ID'] == $credit['IDConto']) echo 'selected'; ?>>
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
    <?php else : ?>
        <p>Credit not found.</p>
    <?php endif; ?>
</body>

</html>