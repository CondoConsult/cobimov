<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../db/dbh.php';

        $button = $_POST['button'];

        switch ($button) {
            case 'insert':
                insert($pdo);
                break;
            case 'approve':
            case 'paid':
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

            if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
                require_once 'upload_file.php';
                $fileNameNew = uploadFile(); // Get the file name returned by the function
            } 

            $chavePix = $_POST['chave-pix-boleto'];
            $valor = $_POST['valor'];
            $solicitante = $_POST['solicitante'];
            $metodoPagamento = $_POST['metodo-pagamento'];
            $classe = $_POST['classe'];
            $descricao = $_POST['descricao'];
            
            $query = 'INSERT INTO colaborador_pagamentos (chave_pix_boleto, metodo_pagamento, classe, descricao, valor, solicitante, anexo)
                      VALUES (:chavepixboleto, :metodopagamento, :classe, :descricao, :valor, :solicitante, :anexo);';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':chavepixboleto', $chavePix);
            $stmt->bindParam(':metodopagamento', $metodoPagamento);
            $stmt->bindParam(':classe', $classe);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':solicitante', $solicitante);
            $stmt->bindParam(':anexo', $fileNameNew);

            if (!$stmt->execute()) {
                echo "error";
            }

            header('Location: ../../pages/colaborador_pagamentos');
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

            header('Location: ../../pages/colaborador_pagamentos');
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
            } elseif ($button == 'paid') {
                $statuspagamento = 'pago';
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

            header('Location: ../../pages/colaborador_pagamentos');
            $pdo = null;
            $stmt = null;
            die();

        } catch (PDOException $error) {
            die('Query failed: ' . $error->getMessage());
        }
    }