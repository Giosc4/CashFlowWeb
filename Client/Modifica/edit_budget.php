<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';

// Get budget ID from query parameters
$id = $_GET['id'] ?? null;

// Fetch the budget details from the database using the budget ID
$budget = $id ? getBudgetFromID($id) : null;

global $selectCategoriaPrimariaFromEmail;
$primaryCategories = getTableBYEmail($_SESSION['email'], $selectCategoriaPrimariaFromEmail);

// Check if budget exists
if (!$budget) {
    echo "Budget not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
               
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: red;
        }

        .delete-button:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php'; ?> <br><br>

    <h1>Edit Budget</h1>
    <?php if ($budget) : ?>
        <form action="../../server/modifica/edit_budget_server.php" method="post">
            <!-- Hidden field to send the budget ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($budget['ID']); ?>">

            <!-- Field to edit the budget name -->
            <div>
                <label for="nomeBudget">Budget Name:</label>
                <input type="text" id="nomeBudget" name="NomeBudget" value="<?php echo htmlspecialchars($budget['NomeBudget']); ?>" required>
            </div>

            <!-- Field to edit the budget maximum amount -->
            <div>
                <label for="importoMax">Maximum Importo:</label>
                <input type="number" id="importoMax" name="ImportoMax" value="<?php echo htmlspecialchars($budget['ImportoMax']); ?>" step="0.01" required>
            </div>

            <!-- Field to edit the budget start date -->
            <div>
                <label for="dataInizio">Start Date:</label>
                <input type="date" id="dataInizio" name="DataInizio" value="<?php echo htmlspecialchars($budget['DataInizio']); ?>" required>
            </div>

            <!-- Field to edit the budget end date -->
            <div>
                <label for="dataFine">End Date:</label>
                <input type="date" id="dataFine" name="DataFine" value="<?php echo htmlspecialchars($budget['DataFine']); ?>" required>
            </div>

            <!-- Primary Category Selection -->
            <div>
                <label for="primaryCategoryId">Seleziona la Categoria Primaria:</label>
                <select id="primaryCategoryId" name="IDPrimaryCategory" required>
                    <option value="" disabled <?php if (!$budget['IDPrimaryCategory']) echo 'selected'; ?>>Seleziona la Categoria Primaria</option>
                    <?php foreach ($primaryCategories as $category) : ?>
                        <option value="<?php echo htmlspecialchars($category['ID']); ?>" <?php if ($category['ID'] == $budget['IDPrimaryCategory']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['NomeCategoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <!-- Submit button to save changes -->
            <div>
                <button type="submit">Save Changes</button>
            </div>
        </form>
        <form action="../../server/eliminazione/delete_budget.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($budget['ID']); ?>">
            <button type="submit" class="delete-button">Elimina Budget</button>
        </form>
    <?php else : ?>
        <p>Budget not found.</p>
    <?php endif; ?>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>