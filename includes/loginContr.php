<?php

declare(strict_types=1);

function isInputEmpty(string $usuario, string $senha) {
    if (empty($usuario) || empty($senha)) {
        return true;
    } else {
        return false;
    }
}

function isUsernameWrong(bool|array $result) {
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function isPasswordWrong(string $senha, string $hashedPwd) {
    if (!password_verify($senha, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}
