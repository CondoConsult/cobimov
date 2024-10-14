<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../db/dbh.php';

    $button = $_POST['button'];
    $mesReferencia = $_POST['MesReferencia'];

    switch ($button) {
        case 'insert':
            checkData($pdo);
            break;
        
        case 'delete':
            delete($pdo);
            break;
    }
}

//CHECK IF RECORD EXISTIS ON DB
function checkData($pdo){

    $condID = $_POST['CondID'];
    $mesReferencia = $_POST['MesReferencia'];

    $query = "SELECT * FROM UnidadesRemessa WHERE CondID = :condid AND MesReferencia = :mesreferencia;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);
    $stmt->bindParam(":mesreferencia", $mesReferencia);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        insert($pdo);
    } else {
        update($pdo);
    }
}


function insert($pdo){

    $condID = $_POST['CondID'];
    $mesReferencia = $_POST['MesReferencia'];
    $boletosExtras = $_POST['BoletosExtras'];
    $boletosUnicos = $_POST['BoletosUnicos'];
    $unidadesBoletosUnicos = $_POST['UnidadesBoletosUnicos'];

    $query = "INSERT INTO UnidadesRemessa (CondID, MesReferencia, BoletosExtras, BoletosUnicos, UnidadesBoletosUnicos)
              VALUES (:condid, :mesreferencia, :boletosextras, :boletosunicos, :unidadesboletosunicos);";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);
    $stmt->bindParam(":mesreferencia", $mesReferencia);
    $stmt->bindParam(":boletosextras", $boletosExtras);
    $stmt->bindParam(":boletosunicos", $boletosUnicos);
    $stmt->bindParam(":unidadesboletosunicos", $unidadesBoletosUnicos);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroEfetuado('numero_boletos');
    } else {
        echo 'Error';
    }

    $stmt = null;
    $pdo = null;

};

//UPDATE
function update($pdo){

    $condID = $_POST['CondID'];
    $mesReferencia = $_POST['MesReferencia'];
    $boletosExtras = $_POST['BoletosExtras'];
    $boletosUnicos = $_POST['BoletosUnicos'];
    $unidadesBoletosUnicos = $_POST['UnidadesBoletosUnicos'];

    $query = "UPDATE UnidadesRemessa
              SET MesReferencia = :mesreferencia,
                  BoletosExtras = :boletosextras,
                  BoletosUnicos = :boletosunicos,
                  UnidadesBoletosUnicos = :unidadesboletosunicos
              WHERE CondID = :condid AND MesReferencia = :mesreferencia;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);
    $stmt->bindParam(":mesreferencia", $mesReferencia);
    $stmt->bindParam(":boletosextras", $boletosExtras);
    $stmt->bindParam(":boletosunicos", $boletosUnicos);
    $stmt->bindParam(":unidadesboletosunicos", $unidadesBoletosUnicos);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroAtualizado('numero_boletos');
    } else {
        echo 'Error';
    }

    $stmt = null;
    $pdo = null;
}

//DELETE
function delete($pdo){

    $condID = $_POST['CondID'];
    $mesReferencia = $_POST['MesReferencia'];

    $query = "DELETE FROM UnidadesRemessa WHERE CondID = :condid AND MesReferencia = :mesreferencia;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);
    $stmt->bindParam(":mesreferencia", $mesReferencia);
    $stmt->execute();

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroRemovido('numero_boletos');
    } else {
        echo 'Error';
    }

}
