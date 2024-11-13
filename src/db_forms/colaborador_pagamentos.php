<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../db/dbh.php';

        $button = $_POST['button'];

        switch ($button) {
            case 'insert':
                insert($pdo);
                break;
            case 'approve':
            case 'deny':
                update($pdo, $button);
                break;
            case 'delete':
                delete($pdo);
                break;
        }
    } else {
        header('Location: ../pages/home');
    }

    function insert($pdo) {
        try {

            $chavePix = $_POST['chave-pix'];
            $valor = $_POST['valor'];
            $solicitante = $_POST['solicitante'];
            $descricao = $_POST['classe'];
            
            $query = 'INSERT INTO colaborador_pagamentos (chave_pix, descricao, valor, solicitante)
                      VALUES (:chavepix, :descricao, :valor, :solicitante);';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':chavepix', $chavePix);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':solicitante', $solicitante);

            if (!$stmt->execute()) {
                echo "error";
            }

            header('Location: ../../pages/colaborador_consultar_pagamentos');
            $pdo = null;
            $stmt = null;
            die();

        } catch (PDOException $error) {
            die('Query failed: ' . $error->getMessage());
        }
    }

    function delete($pdo) {
        try {

            $pagamentoID = $_POST['pagamento-id'];
            
            $query = 'DELETE FROM colaborador_pagamentos
                      WHERE pagamento_id = :pagamentoid;';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':pagamentoid', $pagamentoID);

            if (!$stmt->execute()) {
                echo "error";
            }

            header('Location: ../../pages/colaborador_consultar_pagamentos');
            $pdo = null;
            $stmt = null;
            die();

        } catch (PDOException $error) {
            die('Query failed: ' . $error->getMessage());
        }
    }

    function update($pdo, $button) {
        try {
          
            $pagamentoID = $_POST['pagamento-id'];

            if ($button == 'approve') {
                $statuspagamento = 'aprovado';
            } elseif ($button == 'deny') {
                $statuspagamento = 'negado';
            }
            
            $query = 'UPDATE colaborador_pagamentos
                      SET status_pagamento = :statuspagamento
                      WHERE pagamento_id = :pagamentoid;';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':pagamentoid', $pagamentoID);
            $stmt->bindParam(':statuspagamento', $statuspagamento);

            if (!$stmt->execute()) {
                echo "error";
            }

            header('Location: ../../pages/colaborador_gerenciar_pagamentos');
            $pdo = null;
            $stmt = null;
            die();

        } catch (PDOException $error) {
            die('Query failed: ' . $error->getMessage());
        }
    }