<?php
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($nickname) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "Dati inseriti non validi.";
        header("Location: ../../client/new_profile_client.php?error=emptyfields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email non valida.";
        header("Location: ../../client/new_profile_client.php?error=invalidEmail");

        exit();
    }

    if ($password !== $confirmPassword) {
        echo "Le password non corrispondono.";
        header("Location: ../../client/new_profile_client.php?error=pswdsDontMatch");
        exit();
    }

    if (userExists($email)) {
        echo "Utente già esistente.";
        header("Location: ../../client/new_profile_client.php?error=userExists");
        exit();
    }

    // Chiamata alla funzione createProfile
    $result = createProfile($nickname, $email, $password, $confirmPassword);

    // Controlla il risultato della funzione e reindirizza o mostra un errore
    if ($result === "Profilo creato con successo.") {
        $_SESSION['email'] = $email;
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo $result;
    }
} else {
    // Reindirizza alla pagina del form se il metodo non è POST
    header("Location: ../../error.php");
    exit();
}
