<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"]) && isset($_POST["saldo"])) {

        $nome = $_POST["nome"];
        $saldo = $_POST["saldo"];

        createConto($nome, $saldo);

        header("Location: ../client/index.php");
        exit();
    } else {
        echo "Errore: Tutti i campi sono obbligatori.";
    }
}
