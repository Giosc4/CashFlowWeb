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
    echo "Debito non trovato.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Debito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
               
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: red;
        }

        .delete-button:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php'; ?> <br><br>
    <h1>Edit Debito</h1>
    <?php if ($debit) : ?>
        <form action="../../server/modifica/edit_debit_server.php" method="post">
            <!-- Hidden field to send the debit ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($debit['ID']); ?>">

            <!-- Field to edit the debit amount -->
            <div>
                <label for="importoDebito">Importo del Debito:</label>
                <input type="number" id="importoDebito" name="ImportoDebito" value="<?php echo htmlspecialchars($debit['ImportoDebito']); ?>" step="0.01" required>
            </div>

            <!-- Field to edit the debit name -->
            <div>
                <label for="nomeImporto">Nome del Debito:</label>
                <input type="text" id="nomeImporto" name="NomeImporto" value="<?php echo htmlspecialchars($debit['NomeImporto']); ?>" required>
            </div>

            <!-- Field to edit the concession date -->
            <div>
                <label for="dataConcessione">Data di Concessione:</label>
                <input type="date" id="dataConcessione" name="DataConcessione" value="<?php echo htmlspecialchars($debit['DataConcessione']); ?>" required>
            </div>

            <!-- Field to edit the extinction date -->
            <div>
                <label for="dataEstinsione">Data di Estinzione:</label>
                <input type="date" id="dataEstinsione" name="DataEstinsione" value="<?php echo htmlspecialchars($debit['DataEstinsione']); ?>" required>
            </div>

            <!-- Field to edit the notes -->
            <div>
                <label for="note">Note:</label>
                <textarea id="note" name="Note"><?php echo htmlspecialchars($debit['Note']); ?></textarea>
            </div>

            <!-- Account Selection -->
            <div>
                <label for="IDConto">Seleziona un Conto:</label>
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
                <button type="submit">Salva Modifiche</button>
            </div>
        </form>
        <form action="../../server/eliminazione/delete_debit.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($debit['ID']); ?>">
            <button type="submit" class="delete-button">Elimina Debito</button>
        </form>
    <?php else : ?>
        <p>Debito non trovato.</p>
    <?php endif; ?>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>