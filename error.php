<h1>ERRORE</h1>

<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<p>{$_SESSION['error']}</p>";
    unset($_SESSION['error']);
}
?>