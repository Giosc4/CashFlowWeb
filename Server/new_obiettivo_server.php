<?php
require_once '../db/write_functions.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["obiettivoName"]) && isset($_POST["obiettivoAmount"]) && isset($_POST["obiettivoDateInizio"]) && isset($_POST["contoId"])) {

        $obiettivoName = $_POST["obiettivoName"];
        $obiettivoAmount = $_POST["obiettivoAmount"];
        $obiettivoDateInizio = $_POST["obiettivoDateInizio"];
        $contoId = $_POST["contoId"];

        // $idContoFromNome = getIdContoFromNome($contoId);
        // echo $idContoFromNome;

        createObiettivo($obiettivoName, $obiettivoAmount, $obiettivoDateInizio, $contoId);
        header("Location: ../client/index.php");
        exit();
    } else {
        echo "Errore: Tutti i campi sono obbligatori.";
    }
}
