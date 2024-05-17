<?php
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/db_connection.php';
require_once 'C:/Users/giova/xampp/htdocs/CashFlowWeb/db/queries.php';


// questa funzione controlla se esiste un utente con la stessa email
function userExists($email)
{
    global $conn, $selectUserByEmail ;

    $stmt = $conn->prepare($selectUserByEmail );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function getIdContoFromNome($nomeConto)
{
    global $conn, $selectIdContoFromNome ;

    $stmt = $conn->prepare($selectIdContoFromNome );
    $stmt->bind_param("s", $nomeConto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (isset($row['IDConto'])) {
            $idConto = $row['ID'];
            $stmt->close();
            return $idConto;
        } else {
            echo "Errore: Chiave 'IDConto' non presente nell'array.";
        }
    } else {
        echo "Errore: Nessun conto trovato con il nome '$nomeConto'.";
    }

    $stmt->close();
    return null;
}

function getProfiloByEmail($email)
{
    global $conn, $selectUserByEmail ;

    $stmt = $conn->prepare($selectUserByEmail );
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row; // Return the whole row as an associative array.
    } else {
        $stmt->close();
        return false;
    }
}


function getIDProfiloByEmail($email)
{
    global $conn, $selectIDProfileByEmail ;

    $stmt = $conn->prepare($selectIDProfileByEmail );
    if (!$stmt) {
        error_log("MySQL prepare error: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        error_log("Execute error: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row['ID'];
    } else {
        $stmt->close();
        return false;
    }
}


function logInProfile($email, $password)
{
    global $conn, $selectIDProfileByEmail ;

    $stmt = $conn->prepare($selectIDProfileByEmail );
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session and save the email to the session
            session_start();
            $_SESSION['email'] = $email;
            $stmt->close();
            return true;
        } else {
            // Password is incorrect
            echo "Errore: La password non è corretta.";
        }
    } else {
        // No account found with the provided email
        echo "Errore: Nessun account trovato con l'email '$email'.";
    }

    $stmt->close();
    return false;
}

function getTableBYEmail($email, $query)
{
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
