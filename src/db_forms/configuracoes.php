<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db/dbh.php';

    $usuarioID = $_POST['usuario-id'];
    $tema = $_POST['tema'];

    $query = 'UPDATE Usuarios
              SET Tema = :tema
              WHERE UsuarioID = :usuarioid;';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':tema', $tema);
    $stmt->bindParam(':usuarioid', $usuarioID);

    if ($stmt->execute()) {
        header('Location: ../../pages/configuracoes_tema.php');
    } else {
        echo 'error';
    }

    $pdo = null;

} else {
    header('Location: ../pages/home.php');
}