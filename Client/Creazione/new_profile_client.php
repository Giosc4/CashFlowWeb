<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Profilo</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #ff0000;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
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
    <br>
    <a href="../log_in_profile_client.php">Log In</a>


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
    ?>    <br> <br> <?php require('../footer.php') ?>

</body>

</html>