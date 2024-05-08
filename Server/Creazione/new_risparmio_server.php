<?php
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["amount"]) && isset($_POST["risparmioDateInizio"]) && isset($_POST["risparmioDateFine"]) && isset($_POST["contoId"])) {

        $amount = $_POST["amount"];
        $risparmioDateInizio = $_POST["risparmioDateInizio"];
        $risparmioDateFine = $_POST["risparmioDateFine"];
        $contoId = $_POST["contoId"];

        $idContoFromNome = getIdContoFromNome($contoId);

        createRisparmio($amount, $risparmioDateInizio, $risparmioDateFine, $contoId);
        header("Location: ../../client/index.php");
        exit();
    } else {
        echo "Errore: Tutti i campi sono obbligatori.";
    }
}
