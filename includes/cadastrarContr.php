<?php

declare(strict_types=1);

function isInputEmpty(string $usuario, string $senha, string $email) {
    if (empty($usuario) || empty($senha) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function isEmailInvalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        return true;
    } else {
        return false;
    }
}

function isUsernameTaken(object $pdo, string $usuario) {
    if (getUsername($pdo, $usuario)) {
        return true;
    } else {
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email) {
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function createUser(object $pdo, string $senha, string $usuario, string $email, string $permissoes) {
   setUser($pdo, $senha, $usuario, $email, $permissoes);
}
