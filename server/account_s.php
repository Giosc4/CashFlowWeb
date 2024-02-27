<?php
require_once '../db/db.php';
require_once '../db/write_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['submit']) ? $_POST['submit'] : 'default';

    if ($action == 'deleteAccount') {
        $nomeAccount = $_POST['idAccount'];
        echo $nomeAccount;  
        deleteAccount($nomeAccount);
        // header('Location: ../client/index.php');
        // exit();
    } elseif ($action == 'createAccount') {

        $nomeAccount = $_POST['nomeAccount'];
        $saldo = $_POST['saldo'];

        if (empty($nomeAccount)) {
            die('Il Nome Account è obbligatorio.');
        } else if (!is_numeric($saldo)) {
            die('Il saldo deve essere un numero.');
        } else {
            createAccount($nomeAccount, $saldo);
            header('Location: ../client/index.php');
            exit();
        }
    }

    $conn->close();
}
