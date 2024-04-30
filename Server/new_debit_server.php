<?php
require_once '../db/write_functions.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';

// Processo il form se è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["titolo"]) && isset($_POST["amount"]) && isset($_POST["debitConcessioneDate"])
        && isset($_POST["debitEstinsioneDate"]) && isset($_POST["contoId"]) && isset($_POST["description"])
    ) {

        // Prendi i valori dal form
        $titolo = $_POST["titolo"];
        $amount = $_POST["amount"];
        $debitConcessioneDate = $_POST["debitConcessioneDate"];
        $debitEstinsioneDate = $_POST["debitEstinsioneDate"];
        $contoId = $_POST["contoId"];
        $description = $_POST["description"];

        createDebit($titolo, $amount, $debitConcessioneDate, $debitEstinsioneDate, $description, $contoId);
        header("Location: ../client/index.php");
        exit();
    }
}
