<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';


// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assegna i dati inviati dal form a variabili
    $budgetName = $_POST['budgetName'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $budgetStartDate = $_POST['budgetStartDate'] ?? date('Y-m-d');
    $budgetEndDate = $_POST['budgetEndDate'] ?? date('Y-m-d');
    $categoryId = $_POST['categoryId'] ?? 0;

    // Validazione dei dati (esempio molto semplice)
    if (empty($budgetName) || $amount <= 0 || empty($categoryId)) {
        echo "Please fill all the fields correctly.";
    } else {
        // Prepara e invia il comando SQL al database
        $sql = "INSERT INTO budgets (name, amount, start_date, end_date, category_id) VALUES (?, ?, ?, ?, ?)";
        
        // Utilizzando MySQLi per la connessione e l'inserimento dei dati
        $conn = new mysqli('your_server', 'your_username', 'your_password', 'your_database');

        // Controlla la connessione
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepara la query SQL
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("SQL error: " . $conn->error);
        }

        // Collega i parametri alla query SQL
        $stmt->bind_param("sdsss", $budgetName, $amount, $budgetStartDate, $budgetEndDate, $categoryId);

        // Esegui la query
        if ($stmt->execute()) {
            echo "New budget created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Chiudi lo statement e la connessione
        $stmt->close();
        $conn->close();
    }
} else {
    // Se il metodo non è POST, reindirizza al form
    header('Location: index.html');
    exit;
}

?>
