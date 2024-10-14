<?php

declare(strict_types=1);

function getUser(object $pdo, string $usuario) {
    $query = "SELECT * FROM Usuarios WHERE Usuario = :usuario;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}