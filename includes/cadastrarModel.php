<?php

declare(strict_types=1);

function getUsername(object $pdo, string $usuario) {

    $query = "SELECT Usuario FROM Usuarios WHERE Usuario = :usuario;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
    
}

function getEmail(object $pdo, string $email) {

    $query = "SELECT Email FROM Usuarios WHERE Email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;

}

function setUser(object $pdo, string $senha, string $usuario, string $email, string $permissoes) {

    $query = "INSERT INTO Usuarios (Usuario, Senha, Email, Permissoes) VALUES (:usuario, :senha, :email, :permissoes);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashedPwd = password_hash($senha, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":usuario", $usuario);
    $stmt->bindParam(":senha", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":permissoes", $permissoes);
    $stmt->execute();

}