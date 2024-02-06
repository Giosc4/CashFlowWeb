<?php
require_once '../db/queries.php';
require_once '../db/db.php';

function createAccount($nomeAccount, $saldo)
{
    // Prepara la query SQL per inserire i dati
    global $conn, $insertAccountQuery;

    $stmt = $conn->prepare($insertAccountQuery);
    $stmt->bind_param("ss", $nomeAccount, $saldo);
    $stmt->execute();
    $stmt->close();
}

// Funzione per creare una posizione
function createPosition($longitudine, $latitudine, $nomeCitta)
{
    global $conn, $insertPositionQuery;

    $stmt = $conn->prepare($insertPositionQuery);
    $stmt->bind_param("dds", $longitudine, $latitudine, $nomeCitta); // Assumi dds come formato dei parametri: d = double, s = string
    $stmt->execute();
    $stmt->close();
}

// Funzione per creare una categoria primaria
function createCategoriaPrimaria($nomeCategoria, $descrizioneCategoria)
{
    global $conn, $insertCategoriaPrimariaQuery;

    $stmt = $conn->prepare($insertCategoriaPrimariaQuery);
    $stmt->bind_param("ss", $nomeCategoria, $descrizioneCategoria);
    $stmt->execute();
    $stmt->close();
}

// Funzione per creare una categoria secondaria
function createCategoriaSecondaria($idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria)
{
    global $conn, $insertCategoriaSecondariaQuery;

    $stmt = $conn->prepare($insertCategoriaSecondariaQuery);
    $stmt->bind_param("iss", $idCategoriaPrimaria, $nomeCategoria, $descrizioneCategoria); // i = integer, s = string
    $stmt->execute();
    $stmt->close();
}
