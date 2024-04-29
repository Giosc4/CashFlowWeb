<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["amount"]) && isset($_POST["risparmioDateInizio"]) && isset($_POST["risparmioDateFine"]) && isset($_POST["contoId"])) {

        $amount = $_POST["amount"];
        $risparmioDateInizio = $_POST["risparmioDateInizio"];
        $risparmioDateFine = $_POST["risparmioDateFine"];
        $contoId = $_POST["contoId"];

        $idContoFromNome = getIdContoFromNome($contoId);
        echo $idContoFromNome;

        if ($idContoFromNome) {
            createRisparmio($amount, $risparmioDateInizio, $risparmioDateFine, $idContoFromNome);
            header("Location: ../client/index.php");
            exit();
        } else {
            echo "Errore: Il conto selezionato non esiste.";
        }
    } else {
        echo "Errore: Tutti i campi sono obbligatori.";
    }
}
