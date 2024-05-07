<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../log_in_profile_client.php");
    exit();
}

require '../../db/read_functions.php';

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget</title>
</head>
<body>
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
                <label for="importoMax">Maximum Amount:</label>
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
                <label for="primaryCategoryId">Select a Primary Category:</label>
                <select id="primaryCategoryId" name="IDPrimaryCategory" required>
                    <option value="" disabled <?php if (!$budget['IDPrimaryCategory']) echo 'selected'; ?>>Please select a Primary Category</option>
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
            <button type="submit" style="background-color: red; color: white;">Elimina Budget</button>
        </form>

    <?php else : ?>
        <p>Budget not found.</p>
    <?php endif; ?>
</body>
</html>
