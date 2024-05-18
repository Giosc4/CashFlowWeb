<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"]) && isset($_POST["saldo"])) {
        $nome = $_POST["nome"];
        $saldo = $_POST["saldo"] ?? 0;

        $profiloID = getIDProfiloByEmail($_SESSION['email']);
        $contoID = createConto($nome, $saldo, $profiloID);

        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "Errore: Tutti i campi sono obbligatori.";
    }
}
