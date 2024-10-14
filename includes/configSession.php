<?php
// Ensure no output before this point
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 2592000, // 3 months in seconds
    'domain' => $_SERVER['HTTP_HOST'], // Set to your domain
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start(); // Ensure this is called after setting parameters

if (isset($_SESSION["user_id"])) { // Check if the user is logged in
    if (!isset($_SESSION["last_regeneration"])) {
        regenerateSessionIDLoggedIn(); // Call function
    } else {
        $interval = 86400;
        if (time() - $_SESSION["last_regeneration"] >= $interval ) {
            regenerateSessionIDLoggedIn(); // Call function to regenerate the session
        }
    } 
} else { // If not logged in run the code below
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id(); // Call function
    } else {
        $interval = 86400;
        if (time() - $_SESSION["last_regeneration"] >= $interval ) {
            regenerate_session_id(); // Call function to regenerate the session
        }
    } 
}

// Create a function to not use duplicated code inside if

function regenerateSessionIDLoggedIn() {
    session_regenerate_id(true);

    $userID = $_SESSION["user_id"];
    $newSessionID = session_id();
    $sessionID = $newSessionID . "_" . $userID;
    session_id($sessionID);

    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}
?>