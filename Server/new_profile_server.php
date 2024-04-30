<?php
require_once '../db/write_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Chiamata alla funzione createProfile
    $result = createProfile($nickname, $email, $password, $confirmPassword);

    // Controlla il risultato della funzione e reindirizza o mostra un errore
    if ($result === "Profilo creato con successo.") {
        header("Location: ../client/index.php");
        exit();
    } else {
        echo $result;
    }
} else {
    // Reindirizza alla pagina del form se il metodo non è POST
    header("Location: form_page.php");
    exit();
}
?>
