<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Include il file autoload di Composer

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

// Crea una nuova istanza di MongoDB\Client
$mongoClient = new Client("mongodb://localhost:27017");

// Seleziona il database e la collezione
$logCollection = $mongoClient->selectCollection('cashflowmongo', 'eventLogs');

// Funzione per registrare un evento
function logEvent($action, $details) {
    global $logCollection;
    
    $date = date("Y/m/d");
    // Crea un nuovo documento di log
    $logEntry = [
        'timestamp' => $date, 
        'action' => $action,
        'details' => $details
    ];
    
    // Inserisce il documento nella collezione
    $logCollection->insertOne($logEntry);
}
?>