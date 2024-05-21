<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Cash Flow Web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            text-align: center;
            padding: 20px;
        }

        .navbar h1 {
            color: white;
            margin: 0;
        }

        .navbar .buttons,
        .navbar .creation-buttons {
            margin-top: 10px;
        }

        .navbar .buttons a,
        .navbar .creation-buttons a {
            padding: 14px 20px;
            margin: 5px;
            background-color: #444;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .navbar .buttons a:hover,
        .navbar .creation-buttons a:hover {
            background-color: #555;
        }

        .navbar .creation-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .navbar .creation-buttons a {
            flex: 1 1 20%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h1><?php echo "Cash Flow Web"; ?></h1>
        <div class="buttons">
            <a href="/CashFlowWeb/Client/index.php">Home</a>
            <a href="/CashFlowWeb/Client/grafici.php">Grafici</a>
            <a href="/CashFlowWeb/Client/exportData.php">Genera Report CSV</a>
            <a href="/CashFlowWeb/Client/logout.php">Logout</a>
        </div>
        <div>
            <h3 style="color: white;">Creazione</h3>
            <div class="creation-buttons">
                <a href="/CashFlowWeb/Client/Creazione/new_conto_client.php">Creazione Conto</a>
                <a href="/CashFlowWeb/Client/Creazione/new_categoria_primaria_client.php">Creazione Categoria Primaria</a>
                <a href="/CashFlowWeb/Client/Creazione/new_categoria_secondaria_client.php">Creazione Categoria Secondaria</a>
                <a href="/CashFlowWeb/Client/Creazione/new_template_transaction_client.php">Creazione Template Transazione</a>
                <a href="/CashFlowWeb/Client/Creazione/new_risparmio_client.php">Creazione di un Risparmio</a>
                <a href="/CashFlowWeb/Client/Creazione/new_debit_client.php">Creazione di un Debito</a>
                <a href="/CashFlowWeb/Client/Creazione/new_credit_client.php">Creazione di un Credito</a>
                <a href="/CashFlowWeb/Client/Creazione/new_budget_client.php">Creazione di un Budget</a>
                <a href="/CashFlowWeb/Client/Creazione/new_transaction_client.php">Creazione Transazione</a>
            </div>
        </div>
    </div>
</body>

</html>