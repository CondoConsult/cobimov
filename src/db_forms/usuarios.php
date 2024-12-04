<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../db/dbh.php';
    $button = $_POST['button'];

    switch ($button) {
        case 'insert':

            break;

        case 'update':
            break;

        case 'delete':
            delete($pdo);
            break;
    }
    
} else {
    header("Location: usuarios.php");
}

function delete($pdo) {
    try {
        $userID = $_POST["user-id"];

        $query = 'DELETE FROM Usuarios WHERE UsuarioID = :userid;';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userid", $userID);
        
        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroRemovido('usuarios');
        } else {
            echo "Error: Unable to execute query.";
        }

    } catch (PDOException $error) {
        die('Query failed' . $error->getMessage());
    }
}