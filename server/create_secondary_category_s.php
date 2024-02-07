<?php
require_once '../db/db.php'; // Assicurati che questo percorso sia corretto
require_once '../db/write_db.php'; // Include le funzioni per scrivere nel database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Estrai e sanifica l'input del form
    $idCategoriaPrimaria = $_POST['idCategoriaPrimaria'];
    $nomeCategoria = $_POST['nomeCategoria'];
    $descrizioneCategoria = $_POST['descrizioneCategoria'];

    // Validazione semplice degli input
    if (empty($nomeCategoria) || $idCategoriaPrimaria != 0) {
        createCategoriaSecondaria($idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria); 
        header('Location: ../client/index.php');
        exit();
    } else {
        die('Il campo Nome Categoria è obbligatorio.');
        header('Location: ../error.php');
        exit();
    }

}
