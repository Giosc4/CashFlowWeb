<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <h1>Log In</h1>
    <form action="../server/log_in_profile_server.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Log In">
    </form>

    <a href="../client/new_profile_client.php">Crea un nuovo profilo</a>

    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo "<p>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
</body>
</html>
