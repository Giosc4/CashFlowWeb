<?php
session_start();

// Elimina tutte le variabili di sessione
session_unset();

// Distrugge la sessione
session_destroy();

// Reindirizza l'utente alla pagina di accesso dopo il logout
header("Location: ../client/log_in_profile_client.php");
exit();
