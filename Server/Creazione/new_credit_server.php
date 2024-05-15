<?php
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';



// Processo il form se è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["titolo"]) && isset($_POST["amount"]) && isset($_POST["creditConcessioneDate"]) &&
        isset($_POST["creditEstinsioneDate"]) && isset($_POST["contoId"]) && isset($_POST["description"]) &&
        isset($_POST["categoriaPrimariaId"])  // Aggiunto controllo per la categoria primaria
    ) {
        // Prendi i valori dal form
        $titolo = $_POST["titolo"];
        $amount = $_POST["amount"];
        $creditConcessioneDate = $_POST["creditConcessioneDate"];
        $creditEstinsioneDate = $_POST["creditEstinsioneDate"];
        $contoId = $_POST["contoId"];
        $description = $_POST["description"];
        $categoriaPrimariaId = $_POST["categoriaPrimariaId"];  

        createCredit($amount, $titolo, $creditConcessioneDate, $creditEstinsioneDate, $description, $contoId, $categoriaPrimariaId); // Assicurati che createCredit accetti il nuovo parametro
        header("Location: ../../client/index.php");
        exit();
    }
}
