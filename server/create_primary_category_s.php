<?php
require_once '../db/db.php';
require_once '../db/write_db.php';

// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeCategoria = $_POST['nomeCategoria'];
    $descrizioneCategoria = $_POST['descrizioneCategoria'] ?? ''; // Utilizza l'operatore di coalescenza null per gestire l'assenza del campo
    $idBudgetMassimo = $_POST['idBudgetMassimo'];

    // Convalida i dati
    if (empty($nomeCategoria)) {
        die('Il campo Nome Categoria è obbligatorio.');
        header('Location: ../error.php');
        exit();
    } else if (!empty($idBudgetMassimo) && !is_numeric($idBudgetMassimo)) {
        die('Il Budget Massimo deve essere un numero.');
        header('Location: ../error.php');
        exit();
    } else {
        // Supponendo che la funzione createCategoriaPrimaria accetti questi parametri
        createCategoriaPrimaria($nomeCategoria, $descrizioneCategoria, $idBudgetMassimo);
        header('Location: ../client/index.php');
        exit();
    }
}
