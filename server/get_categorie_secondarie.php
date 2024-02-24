<?php
// Inclusione del file per la connessione al database, se non già incluso
require_once '../db/db.php';

$idCategoriaPrimaria = $_GET['idCategoriaPrimaria'] ?? ''; // Prendi l'ID della categoria primaria dalla query string

// Preparazione e esecuzione della query al database
$response = [];
if ($idCategoriaPrimaria) {
    $query = "SELECT * FROM categoriasecondaria WHERE IDCategoriaPrimaria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idCategoriaPrimaria);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

// Impostazione dell'header per rispondere con JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
