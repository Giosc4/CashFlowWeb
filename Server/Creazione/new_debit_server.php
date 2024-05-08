<?php
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["titolo"]) && isset($_POST["amount"]) && isset($_POST["debitConcessioneDate"]) &&
        isset($_POST["debitEstinsioneDate"]) && isset($_POST["contoId"]) && isset($_POST["description"]) &&
        isset($_POST["categoriaPrimariaId"])
    ) {
        $titolo = $_POST["titolo"];
        $amount = $_POST["amount"];
        $debitConcessioneDate = $_POST["debitConcessioneDate"];
        $debitEstinsioneDate = $_POST["debitEstinsioneDate"];
        $contoId = $_POST["contoId"];
        $description = $_POST["description"];
        $categoriaPrimariaId = $_POST["categoriaPrimariaId"];

        createDebit($amount, $titolo, $debitConcessioneDate, $debitEstinsioneDate, $description, $contoId, $categoriaPrimariaId);
        header("Location: ../../client/index.php");
        exit();
    }
}
