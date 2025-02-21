<?php
// Starten der Session
session_start();

// Alle Session-Daten löschen
$_SESSION = array();

// Falls du das Session-Cookie löschen möchtest
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Die Session zerstören
session_destroy();

// Weiterleitung zur Startseite oder Login-Seite
header("Location: index.php"); // oder die gewünschte Seite
exit();
?>
