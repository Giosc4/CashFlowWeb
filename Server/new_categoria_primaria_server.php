<?php
require_once '../db/write_functions.php';
require_once '../db/queries.php';
require_once '../db/read_functions.php';
require_once '../server/classes.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["categoryName"]) && isset($_POST["categoryDescription"])) {
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'];
        $budgetId = isset($_POST['budgetId']) && $_POST['budgetId'] !== '' ? $_POST['budgetId'] : NULL;

        createPrimaryCategory($categoryName, $categoryDescription, $budgetId);
        header("Location: ../client/index.php");
        exit();
    }
}
