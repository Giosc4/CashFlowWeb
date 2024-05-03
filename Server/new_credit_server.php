<?php
require_once '../db/write_functions.php';
require_once '../db/read_functions.php';


// Processo il form se è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["titolo"]) && isset($_POST["amount"]) && isset($_POST["creditConcessioneDate"])
        && isset($_POST["creditEstinsioneDate"]) && isset($_POST["contoId"]) && isset($_POST["description"])
    ) {
        // Prendi i valori dal form
        $titolo = $_POST["titolo"];
        $amount = $_POST["amount"];
        $creditConcessioneDate = $_POST["creditConcessioneDate"];
        $creditEstinsioneDate = $_POST["creditEstinsioneDate"];
        $contoId = $_POST["contoId"];
        $description = $_POST["description"];

        createCredit($amount, $titolo, $creditConcessioneDate, $creditEstinsioneDate, $description, $contoId);
        header("Location: ../client/index.php");
        exit();
    }
}
