<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/read_functions.php';

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
</head>

<body>
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
            <button type="submit" style="background-color: red; color: white;">Cancella Conto</button>
        </form>


    <?php else : ?>
        <p>Account non trovato.</p>
    <?php endif; ?>
</body>

</html>