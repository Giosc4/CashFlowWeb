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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
               
        }

        h1 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }

        button[type="submit"]:hover {
            opacity: 0.8;
        }

        button[type="submit"].delete {
            background-color: red;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php'; ?> <br><br>
    <h1>Edit Credit</h1>
    <?php if ($credit) : ?>
        <form action="../../server/modifica/edit_credit_server.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($credit['ID']); ?>">
            <div>
                <label for="nomeCredito">Nome Credito:</label>
                <input type="text" id="nomeCredito" name="NomeCredito" value="<?php echo htmlspecialchars($credit['NomeImporto']); ?>" required>
            </div>

            <div>
                <label for="importoCredito">Importo Credito:</label>
                <input type="number" id="importoCredito" name="ImportoCredito" value="<?php echo htmlspecialchars($credit['ImportoCredito']); ?>" step="0.01" required>
            </div>

            <div>
                <label for="DataConcessione">Data Concessione:</label>
                <input type="date" id="DataConcessione" name="DataConcessione" value="<?php echo htmlspecialchars($credit['DataConcessione']); ?>" required>
            </div>

            <div>
                <label for="dataEstinsione">Data Estinsione:</label>
                <input type="date" id="dataEstinsione" name="dataEstinsione" value="<?php echo htmlspecialchars($credit['DataEstinsione']); ?>">
            </div>

            <div>
                <label for="note">Note:</label>
                <textarea id="note" name="Note"><?php echo htmlspecialchars($credit['Note']); ?></textarea>
            </div>

            <div>
                <label for="IDConto">Seleziona un conto:</label>
                <select id="IDConto" name="IDConto" required>
                    <?php foreach ($accounts as $account) : ?>
                        <option value="<?php echo htmlspecialchars($account['ID']); ?>" <?php if ($account['ID'] == $credit['IDConto']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($account['NomeConto']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <div>
                <button type="submit">Salva Cambiamenti</button>
            </div>
        </form>
        <form action="../../server/eliminazione/delete_crdit.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($credit['ID']); ?>">
            <button type="submit" class="delete">Elimina Credito</button>
        </form>
    <?php else : ?>
        <p class="error">Credit not found.</p>
    <?php endif; ?>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>