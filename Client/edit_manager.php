<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../client/log_in_profile_client.php");
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
    case '4 Categorie Secondarie':
        header("Location: /CashFlowWeb/client/modifica/edit_secondary_categories.php?id=$id");
        break;
    case '5 Utenti':
        header("Location: /CashFlowWeb/client/modifica/edit_users.php?id=$id");
        break;
    case '6 Template Transazioni ':
        header("Location: /CashFlowWeb/client/modifica/edit_template_transactions.php?id=$id");
        break;
    case '7 Risparmi':
        header("Location: /CashFlowWeb/client/modifica/edit_saving.php?id=$id");
        break;

    case '8 Debito':
        header("Location: /CashFlowWeb/client/modifica/edit_debt.php?id=$id");
        break;
    case '9 Credito':
        header("Location: /CashFlowWeb/client/modifica/edit_credit.php?id=$id");
        break;
    case '10 Budget':
        header("Location: /CashFlowWeb/client/modifica/edit_budget.php?id=$id");
        break;

    case '11 Obiettivi':
        header("Location: /CashFlowWeb/client/modifica/edit_goals.php?id=$id");
        break;
    default:
        echo "Invalid table name or ID";
        break;
}

exit();
?>
