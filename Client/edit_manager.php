<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: C:/Users/giova/xampp/htdocs/CashFlowWeb/client/log_in_profile_client.php");
    exit();
}
?>

<?php
// Collect data from the query parameters
$tableName = $_GET['table'] ?? 'defaultTable';
$id = $_GET['id'] ?? 0;

// Based on the table name, determine which edit page to redirect to
switch ($tableName) {
    case '1 Transazioni':
        header("Location: /CashFlowWeb/client/modifica/edit_transactions.php?id=$id");
        break;
    case '2 Conti':
        header("Location: /CashFlowWeb/client/modifica/edit_accounts.php?id=$id");
        break;
    case '3 Categorie Primaria':
        header("Location: /CashFlowWeb/client/modifica/edit_primary_categories.php?id=$id");
        break;
    // Add more cases as needed for each table
    default:
        echo "Invalid table name or ID"; // Handle error or unknown table
        break;
}

exit(); // Ensure no further execution of script after redirection
?>
