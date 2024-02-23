<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../client/css/index.css"> 
    <title>Crea Account</title>
</head>

<body>
    <div id="innnerContent">
        <?php include 'nav&foot.php'; printNav(); ?>

        <h2 class="text-center" style="margin: 20px;">Crea un nuovo account</h2> 
        <div class="container mt-4">
            <form action="../server/create_account_s.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nomeAccount">Nome Account:</label>
                        <input type="text" class="form-control" id="nomeAccount" name="nomeAccount" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="saldo">Saldo:</label>
                        <input type="text" class="form-control" id="saldo" name="saldo" required>
                    </div>
                </div>
                <button type="submit" class="btn" style="background-color: #36ad47; border-color: #36ad47; color: white;">Crea Account</button>
            </form>
        </div>

        <br>
        <div class="text-center" style="margin: 20px;">
            <a href="../client/index.php" class="btn" style="background-color: #ffffe6; color: #36ad47; border-color: #36ad47; border-width: 2px; border-radius: 15px;">Ritorna ad Index</a>
        </div>

        <?php printFoot(); ?>
    </div>
</body>

</html>
