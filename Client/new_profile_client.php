<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Profilo</title>
</head>

<body>
    <form action="../server/new_profile_server.php" method="post">
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
</body>

</html>