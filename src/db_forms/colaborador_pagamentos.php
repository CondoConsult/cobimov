<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../db/dbh.php';

        $button = $_POST['button'];

        switch ($button) {
            case 'insert':
                insert($pdo);
                break;

            case 'delete':

                break;
        }
    } else {
        header('Location: ../pages/home');
    }

    function insert($pdo) {
        try {

            $chavePix = $_POST['chave-pix'];
            $valor = $_POST['valor'];
            $descricao = $_POST['descricao'];
            
            $query = 'INSERT INTO colaborador_pagamentos (chave_pix, descricao, valor)
                      VALUES (:chavepix, :descricao, :valor);';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':chavepix', $chavePix);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':valor', $valor);

            if (!$stmt->execute()) {
                echo "error";
            }

            header('Location: ../../pages/colaborador_solicitar_pagamento');
            $pdo = null;
            $stmt = null;
            die();

        } catch (PDOException $error) {
            die('Query failed: ' . $error->getMessage());
        }
    }