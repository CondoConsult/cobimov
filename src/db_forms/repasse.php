<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db/dbh.php';

    $button = $_POST['button'];

        switch ($button) {
            case 'insert':
                insert($pdo);
                break;
            case 'update':
                update($pdo);
                break;
            case 'delete':
                delete($pdo);
                break;         
        }

} else {
    header('Location: ../pages/programarRepasse.php');
}

function insert($pdo) {
    try {
        $condID = $_POST['cond-id'];
        $contaID = $_POST['conta-id'];
        $valor = $_POST['valor'];
        $dataPagamento = $_POST['data-pagamento'];
        $categoria = $_POST['categoria'];
        $etapa = 'pendente';

        $query = 'INSERT INTO RepassesProgramados (CondID, ContaID, Valor, DataPagamento, Etapa, Categoria)
                  VALUES (:condid, :contaid, :valor, :datapagamento, :etapa, :categoria);';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('condid', $condID);
        $stmt->bindParam('contaid', $contaID);
        $stmt->bindParam('valor', $valor);
        $stmt->bindParam('datapagamento', $dataPagamento);
        $stmt->bindParam('etapa', $etapa);
        $stmt->bindParam('categoria', $categoria);

        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroEfetuado('consultarRepasses');
        } else {
            echo 'error';
        }

        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}

function update($pdo) {
    try {
        $repasseID = $_POST['repasse-id'];
        $valor = $_POST['valor'];
        $dataPagamento = $_POST['data-pagamento'];
        $categoria = $_POST['categoria'];

        $query = 'UPDATE RepassesProgramados 
                  SET Valor = :valor,
                      DataPagamento = :datapagamento,
                      Categoria = :categoria
                  WHERE RepasseID = :repasseid;';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':datapagamento', $dataPagamento);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':repasseid', $repasseID);

        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroAtualizado('consultarRepasses');
        } else {
            echo 'error';
        }

        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}

function delete($pdo) {
    try {
        $repasseID = $_POST['repasse-id'];

        $query = 'DELETE FROM RepassesProgramados 
                  WHERE RepasseID = :repasseid;';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('repasseid', $repasseID);

        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroRemovido('consultarRepasses');
        } else {
            echo 'error';
        }

        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $error) {
        die('Query failed: ' . $error->getMessage());
    }
}