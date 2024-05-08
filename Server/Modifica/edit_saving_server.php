<?php
require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';




// Recupera i dati inviati dal modulo di modifica
$risparmioId = $_POST['id'];
$amount = $_POST['amount'];
$risparmioDateInizio = $_POST['risparmioDateInizio'];
$risparmioDateFine = $_POST['risparmioDateFine'];
$contoId = $_POST['contoId'];

// Aggiorna il risparmio nel database
updateRisparmio($risparmioId, $amount, $risparmioDateInizio, $risparmioDateFine, $contoId);

// Reindirizza alla pagina di visualizzazione del risparmio appena modificato
header("Location: /CashFlowWeb/client/index.php");
exit();
?>
