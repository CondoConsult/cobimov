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
        $condArray = $_POST['condominio'];
        $mesReferencia = $_POST['mes-referencia'];

        foreach ($condArray as $condID) {
            $query = "INSERT INTO rpa_programar_remessa (cond_id, mes_referencia)
            VALUES (:condid, :mesreferencia);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam('condid', $condID);
            $stmt->bindParam('mesreferencia', $mesReferencia);

            if (!$stmt->execute()) {
                echo "error";
            } 
        }

        header('Location: ../../pages/arquivos_remessa_programar.php');
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}

function delete($pdo) {
    try {

        $condID = $_POST['condominio'];
        $mesReferencia = $_POST['mes-referencia'];

        $query = "DELETE FROM rpa_programar_remessa 
                  WHERE cond_id = :condid AND mes_referencia = :mesreferencia AND estado = 'Pendente';";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('condid', $condID);
        $stmt->bindParam('mesreferencia', $mesReferencia);

        if ($stmt->execute()) {
            header('Location: ../../pages/arquivos_remessa_programar.php');
        } else {
            echo "error";
        }
      
    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}