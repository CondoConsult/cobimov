<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    
    try {
        require_once '../db/dbh.php';
        $button = $_POST['button'];
        $condID = $_POST['cond-id'];

        if ($button == "delete") {
            deleteData($pdo, $condID);
        } else {
            checkData($pdo, $condID);
        }
    } catch (PDOException $error) {
        die("Query failed: " . $error->getMessage());
    }

} else {
    header("Location: ../pages/cadastrarCondominio.php"); 
}

function checkData($pdo, $condID) {
    $query = "SELECT * FROM CondominiosInfoSienge WHERE CondID = :condid;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        insertData($pdo, $condID);
    } else {
        updateData($pdo, $condID);
    }
}

function insertData($pdo, $condID) {
    $diasLiquidacao = $_POST['dias-liquidacao'];
    $conta = $_POST['conta'];
    $query = "INSERT INTO CondominiosInfoSienge (CondID, DiasLiquidacao, Conta)
              VALUES (:condid, :diasliquidacao, :conta);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":diasliquidacao", $diasLiquidacao);
    $stmt->bindParam(":condid", $condID);
    $stmt->bindParam(":conta", $conta);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroEfetuado('sienge_cadastro_condominio');
    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;
    die();
}

function deleteData($pdo, $condID) {
    $query = "DELETE FROM CondominiosInfoSienge WHERE CondID = :condid;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroRemovido('sienge_cadastro_condominio');
    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;
    die();
}

function updateData($pdo, $condID) {
    $diasLiquidacao = $_POST['dias-liquidacao'];
    $conta = $_POST['conta'];
    $query = "UPDATE CondominiosInfoSienge 
              SET DiasLiquidacao = :diasliquidacao,
                  Conta = :conta
              WHERE CondID = :condid;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":diasliquidacao", $diasLiquidacao);
    $stmt->bindParam(":condid", $condID);
    $stmt->bindParam(":conta", $conta);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroAtualizado('sienge_cadastro_condominio');
    } else {
        echo "error";
    }
}