<?php

require_once '../db/db.php';
require_once '../db/write_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Imposta i parametri e esegui
    $importo = $_POST["importo"];
    $idAccount = $_POST["idAccount"];
    $dataTransazione = $_POST["dataTransazione"];
    $idCategoriaPrimaria = $_POST['idCategoriaPrimaria'] ?? null;
    $idCategoriaSecondaria = $_POST['idCategoriaSecondaria'] ?? null;
    $descrizione = $_POST['descrizione'] ?? '';
    $isEntrata = isset($_POST['isEntrata']) ? 1 : 0;

    echo $dataTransazione; // Debugging per verificare il valore di $_POST["dataTransazione"]
    
    echo "- " . $isEntrata;

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
