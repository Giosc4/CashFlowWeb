<?php

require_once '../db/db.php';
require_once '../db/write_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST["importo"]); 
    $action = isset($_POST['submit']) ? $_POST['submit'] : 'default';

    if ($action == 'createTransaction') {
        // Imposta i parametri e esegui
        if (empty($_POST["importo"])) {
            die('Il campo Importo è obbligatorio.');
        }
        
        $importo = $_POST["importo"];
        $idAccount = $_POST["idAccount"];
        $dataTransazione = $_POST["dataTransazione"];
        $idCategoriaPrimaria = $_POST['idCategoriaPrimaria'] ?? null;
        $idCategoriaSecondaria = $_POST['idCategoriaSecondaria'] ?? null;
        $descrizione = $_POST['descrizione'] ?? '';
        $isEntrata = !empty($_POST['isEntrata']) ? 1 : 0;
        echo $isEntrata . "<br>" . $idCategoriaPrimaria . "<br>" . $idCategoriaSecondaria . "<br>" . $descrizione . "<br>" . $dataTransazione . "<br>" . $importo . "<br>" . $idAccount . "<br>";

        if (empty($importo) || empty($idAccount) ||  !strtotime($dataTransazione)) {
            die('I campi Tipo, Importo, ID Account e Data Transazione sono obbligatori.');
        } else if (!is_numeric($importo)) {
            die('L\'importo deve essere un numero.');
        } else {

            createTransaction($importo, $idAccount, $dataTransazione, $idCategoriaPrimaria, $idCategoriaSecondaria, $descrizione, $isEntrata);

            // Reindirizza l'utente a una pagina di conferma o all'indice dopo l'inserimento
            header('Location: ../client/index.php');
            exit();
        }
    }
    if ($action == 'deleteTransaction') {

        $idTrans = $_POST['transaction_id'];
        if (empty($idTrans)) {
            die('ID Transazione obbligatorio.');
        } else {
            deleteTransaction($idTrans);
            header('Location: ../client/index.php');
            exit();
        }
    }
}

echo "Errore: richiesta non valida.";
