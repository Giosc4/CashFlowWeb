<?php
session_start();
include_once '../db/read_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $_SESSION['error'] = "Dati inseriti non validi.";
        header("Location: ../client/log_in_profile_client.php");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = "Email non valida.";
        header("Location: ../client/log_in_profile_client.php");
        exit();
    }

    if(!userExists($email)){
        $_SESSION['error'] = "Utente non esistente.";
        header("Location: ../client/log_in_profile_client.php");
        exit();
    }

    $profilo = getProfiloByEmail($email);

    if(!password_verify($password, $profilo['Password'])){
        $_SESSION['error'] = "Email o password errati.";
        header("Location: ../client/log_in_profile_client.php");
        exit();
    }

    // Login corretto, reindirizza all'area riservata
    $_SESSION['email'] = $email;
    header("Location: ../client/index.php");
    exit();
} else {
    // Reindirizza alla pagina del form se il metodo non è POST
    header("Location: form_page.php");
    exit();
}
?>
