<?php
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/write_functions.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/queries.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/read_functions.php';


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
            header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/index.php");
            exit();
        } else {
            echo "Errore: Il conto selezionato non esiste.";
        }
    } else {
        echo "Errore: Tutti i campi sono obbligatori.";
    }
}
