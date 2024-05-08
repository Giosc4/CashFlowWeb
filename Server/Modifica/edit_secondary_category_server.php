<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di accesso
if (!isset($_SESSION['email'])) {
    header("Location: ../../client/log_in_profile_client.php");
    exit();
}

require_once '../../db/delete_functions.php';
require_once '../../db/update_functions.php';
require_once '../../db/fromID_functions.php';
require_once '../../db/queries.php';
require_once '../../db/read_functions.php';
require_once '../../db/write_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['categoryId'], $_POST['categoryName'], $_POST['primaryCategoryId'], $_POST['categoryDescription'])) {
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];
        $primaryCategoryId = $_POST['primaryCategoryId'];
        $categoryDescription = $_POST['categoryDescription'];
        echo $categoryId;
        echo $categoryName;
        echo $primaryCategoryId;
        echo $categoryDescription;

        if (updateSecondaryCategory($categoryId, $categoryName, $primaryCategoryId, $categoryDescription)) {
            header("Location: ../../client/index.php");
            exit();
        } else {
            echo "Error updating secondary category.";
            exit();
        }
    } else {
        echo "All fields are required.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
