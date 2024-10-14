<?php
declare(strict_types=1);

function displayLoginErrors() {
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];
        foreach ($errors as $error) {
            echo "<p>" . htmlspecialchars($error) . "</p>";
        }
        unset($_SESSION["errors_login"]);
    }
}
?>