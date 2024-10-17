<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db/dbh.php';

    $button = $_POST['button'];

        switch ($button) {
            case 'insert':
                insert($pdo);
                break;
            case 'delete':
                delete($pdo);
                break;         
        }

} else {
    header('Location: ../pages/home.php');
}

function insert($pdo) {
    try {
        $telefone = $_POST['numero-telefone'];
        $nomeContato = $_POST['nome-contato'];

        $query = "INSERT INTO rpa_avisos_whatsapp (telefone, nome_contato)
        VALUES (:telefone, :nomecontato);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('telefone', $telefone);
        $stmt->bindParam('nomecontato', $nomeContato);

        if (!$stmt->execute()) {
            echo "error";
        } 

        header('Location: ../../pages/rpa_bloquear_envio.php');
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}

function delete($pdo) {
    try {
        $telefone = $_POST['numero-telefone'];

        $query = "DELETE FROM rpa_avisos_whatsapp 
                  WHERE telefone = :numerotelefone;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('numerotelefone', $telefone);

        if ($stmt->execute()) {
            header('Location: ../../pages/rpa_bloquear_envio.php');
        } else {
            echo "error";
        }
      
    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}