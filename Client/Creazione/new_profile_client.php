<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: client/log_in_profile_client.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Profilo</title>
</head>

<body>
    <form action="http://localhost/CashFlowWeb/server/creazione/new_profile_server.php" method="post">
        <h1>Crea Profilo</h1>
        <label for="name">Nickname:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirmPassword">Conferma Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br>

        <input type="submit" value="Crea Profilo">
    </form>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] === 'emptyfields') {
            echo "<p>Dati inseriti non validi.</p>";
        } else if ($_GET['error'] === 'invalidEmail') {
            echo "<p>Email non valida.</p>";
        } else if ($_GET['error'] === 'pswdsDontMatch') {
            echo "<p>Le password non corrispondono.</p>";
        } else if ($_GET['error'] === 'userExists') {
            echo "<p>Utente già esistente.</p>";
        }
    } else {
        echo "<p>Compila tutti i campi per creare un nuovo profilo.</p>";
    }
    ?>

</body>

</html>