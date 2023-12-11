<?php
require_once 'write_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountName = isset($_POST['accountName']) ? $_POST['accountName'] : "";

    // Verifica che il nome dell'account non sia vuoto
    if (!empty($accountName)) {
        // Chiamata alla funzione per creare un nuovo account
        createAccount($accountName);
        echo "Account creato con successo.";
        header("Location: index.php");
    } else {
        echo "Errore: Il nome dell'account non può essere vuoto.";
    }
}
?>

<form action="create_account.php" method="post">
    <label for="accountName">Account Name:</label><br>
    <input type="text" id="accountName" name="accountName" required autocomplete="off"><br>
    <input type="submit" value="Create Account">
</form>