<?php
require '../db/write_functions.php';

$templateId = $_GET['templateID'];

if (createTransactionFromTemplate($templateId)){
    header('Location: ../Client/index.php');
    exit();
} else {
    echo "Errore nella creazione della transazione";
}
