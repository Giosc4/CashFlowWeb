<?php
session_start();

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

if (isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];

    if (deleteSecondaryCategory($categoryId)) {
        header("Location: ../../client/");
        exit();
    } else {
        echo "Error deleting secondary category.";
        exit();
    }
} else {
    echo "Category ID not provided.";
    exit();
}
?>
