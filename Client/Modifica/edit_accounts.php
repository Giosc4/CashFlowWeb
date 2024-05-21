<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


// Ottieni l'ID dell'account dalla query parameters
$accountId = $_GET['id'] ?? null;

// Recupera i dettagli dell'account dal database usando l'ID dell'account
$account = $accountId ? getAccountById($accountId) : null;

// Check se l'account esiste
if (!$account) {
    echo "Account non trovato.";
    header("Location: /CashFlowWeb/client/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Account</title>
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
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        button {
            background-color: red;
            color: white;
        }

        button:hover,
        input[type="submit"]:hover {
            opacity: 0.8;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<?php include '../navbar.php'; ?> <br><br>
    <h1>Modifica Account</h1>
    <?php if ($account) : ?>
        <form action="../../Server/modifica/edit_account_server.php" method="POST">
            <!-- Campo nascosto per inviare l'ID dell'account -->
            <input type="hidden" name="accountId" value="<?php echo htmlspecialchars($account['ID']); ?>">

            <!-- Campo per visualizzare il nome dell'account -->
            <div>
                <label for="accountName">Nome Account:</label><br>
                <input type="text" id="accountName" name="accountName" value="<?php echo htmlspecialchars($account['NomeConto']); ?>" required autocomplete="off"><br>
            </div>

            <!-- Campo per visualizzare il saldo dell'account -->
            <div>
                <label for="accountBalance">Saldo Account:</label><br>
                <input type="number" id="accountBalance" name="accountBalance" value="<?php echo htmlspecialchars($account['Saldo']); ?>" step="0.01" required>
            </div>

            <!-- Pulsante per inviare le modifiche -->
            <input type="submit" value="Modifica Account">
        </form>
        <form action="../../server/eliminazione/delete_account.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($accountId); ?>">
            <button type="submit">Cancella Conto</button>
        </form>

    <?php else : ?>
        <p class="error">Account non trovato.</p>
    <?php endif; ?>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>