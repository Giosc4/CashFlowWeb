<?php
require_once '/CashFlowWeb/db/read_functions.php';

if (isset($_GET['primaryCategoryId'])) {
    $primaryCategoryId = intval($_GET['primaryCategoryId']);
    $secondaryCategories = getSecondaryFromPrimaryCategories($primaryCategoryId);

    if ($secondaryCategories) {
        header('Content-Type: application/json');
        echo json_encode($secondaryCategories);
    } else {
        header('Content-Type: application/json');
        echo json_encode(["error" => "No categories found"]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "No primary category ID provided"]);
}
