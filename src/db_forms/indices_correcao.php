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
    header('Location: ../../pages/home.php',true);
}

//INSERT
function insert($pdo) {
    try {
        $condominio = $_POST['condominio'];
        $convencao = $_POST['indice-convencao'];
        $contrato = $_POST['indice-contrato'];
        $cond21 = $_POST['indice-cond21'];
        $alteradoPara = $_POST['alterado-para'];
    
        $pdo->beginTransaction();

        $deleteQuery = "DELETE FROM CondominiosIndCorrecao WHERE CondID = :condominioid";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(":condominioid", $condominio);
        $deleteStmt->execute();
    
        $insertQuery = "INSERT INTO CondominiosIndCorrecao
                        (CondID, IndiceConvencao, IndiceContrato, IndiceCond21, AlteradoPara)
                        VALUES 
                        (:condominioid, :convencao, :contrato, :c21, :alteradopara);";
        
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(":condominioid", $condominio);
        $insertStmt->bindParam(":convencao", $convencao);
        $insertStmt->bindParam(":contrato", $contrato);
        $insertStmt->bindParam(":c21", $cond21);
        $insertStmt->bindParam(":alteradopara", $alteradoPara);
        $insertStmt->execute();
    
        $pdo->commit();
    
        include_once '../../public/partials/messages.php';
        cadastroEfetuado('consultarIndicesCorrecao');
    } catch (PDOException $error) {
        $pdo->rollBack();
        die("Query failed: " . $error->getMessage());
    } finally {
        $deleteStmt = null;
        $insertStmt = null;
    }
    
  }

  //UPDATE
  function update($pdo) {
    try {
        $condominio = $_POST['condominio'];
        $convencao = $_POST['indice-convencao'];
        $contrato = $_POST['indice-contrato'];
        $cond21 = $_POST['indice-cond21'];
        $alteradoPara = $_POST['alterado-para'];
        
        $query = "UPDATE CondominiosIndCorrecao
                  SET IndiceConvencao = :convencao,
                  IndiceContrato = :contrato,
                  IndiceCond21 = :c21,
                  AlteradoPara = :alteradopara
                  WHERE CondID = :condominioid;";
  
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":condominioid", $condominio);
        $stmt->bindParam(":convencao", $convencao);
        $stmt->bindParam(":contrato", $contrato);
        $stmt->bindParam(":c21", $cond21);
        $stmt->bindParam(":alteradopara", $alteradoPara);
        
        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroAtualizado('consultarIndicesCorrecao');
        } else {
            echo "Error: Unable to execute query.";
        }
        
        $stmt = null; 
    } catch (PDOException $error) {
        die("Query failed: " . $error->getMessage());
    }
  }

  //DELETE
  function delete($pdo) {
    try {
        $condominio = $_POST['condominio'];
        
        $query = "DELETE FROM CondominiosIndCorrecao
                  WHERE CondID = :condominioid;";
  
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":condominioid", $condominio);
        
        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroRemovido('consultarIndicesCorrecao');
        } else {
            echo "Error: Unable to execute query.";
        }
        
        $stmt = null; 
    } catch (PDOException $error) {
        die("Query failed: " . $error->getMessage());
    }
  }

