<?php

declare(strict_types=1);

function isUserLogged() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
    } 
}