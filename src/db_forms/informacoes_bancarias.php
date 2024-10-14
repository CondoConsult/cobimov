<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $button = $_POST['button'];
    $infoID = $_POST['info-id'];
    $tipoConta = $_POST['tipo-conta'];

    require_once '../db/dbh.php';

    switch ($button) {
        case 'insert':
            insert($pdo);
            break;
        case 'update':
            if ($tipoConta === "Principal") {
                setOtherAccounts($pdo);
                updateData($pdo, $infoID);
            } else {
                updateData($pdo, $infoID);
            }
            break;
        case 'delete':
            deleteData($pdo, $infoID);
            break;
        }

} else {
    header("Location: ../pages/cadastrarInformacoesBancarias.php");
}

//INSERT
function insert($pdo) {
    $condominio = $_POST['condominio'];
    $banco = $_POST['banco'];
    $agencia = $_POST['agencia'];
    $contaDigito = $_POST['conta-digito'];
    $contaNumero = $_POST['conta-numero'];
    $meioPagamento = $_POST['meio-pagamento'];
    $tipoConta = $_POST['tipo-conta'];
    $bloquearRepasse = $_POST['bloquear-repasse'];
    $tipoChave = $_POST['tipo-chave'];
    $pix = $_POST['chave-pix'];
    $cpfcnpjTerceiro = $_POST['cpf-cnpj-terceiro'];

    $query = "INSERT INTO InformacoesBancarias 
              (CondID, BancoID, Agencia, ContaDigito, ContaNumero, TipoConta, BloquearRepasse, MeioPagamento, TipoChave, Pix, CPFCNPJTerceiro)
              VALUES 
              (:condominio, :banco, :agencia, :contadigito, :contanumero, :tipoconta, :bloquearrepasse, :meiopagamento, :tipochave, :pix, :cpfcnpjterceiro);";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":condominio", $condominio);
        $stmt->bindParam(":banco", $banco);
        $stmt->bindParam(":agencia", $agencia);
        $stmt->bindParam(":contadigito", $contaDigito);
        $stmt->bindParam(":contanumero", $contaNumero);
        $stmt->bindParam(":meiopagamento", $meioPagamento);
        $stmt->bindParam(":tipoconta", $tipoConta);
        $stmt->bindParam(":bloquearrepasse", $bloquearRepasse);
        $stmt->bindParam(":tipochave", $tipoChave);
        $stmt->bindParam(":pix", $pix);
        $stmt->bindParam(":cpfcnpjterceiro", $cpfcnpjTerceiro);

        if ($stmt->execute()) {
            include_once '../../public/partials/messages.php';
            cadastroEfetuado('consultarInformacoesBancarias');
        } else {
            echo "error";
        }

        $pdo = null;
        $stmt = null;
}

//UPDATE
function updateData($pdo, $infoID) {

    $agencia = $_POST['agencia'];
    $contaDigito = $_POST['conta-digito'];
    $contaNumero = $_POST['conta-numero'];
    $meioPagamento = $_POST['meio-pagamento'];
    $tipoConta = $_POST['tipo-conta'];
    $bloquearRepasse = $_POST['bloquear-repasse'];
    $tipoChave = $_POST['tipo-chave'];
    $chavePix = $_POST['chave-pix'];
    $cpfcnpjTerceiro = $_POST['cpf-cnpj-terceiro'];

    $query = "UPDATE InformacoesBancarias 
              SET BancoID = :bancoid,
                  Agencia = :agencia, 
                  ContaDigito = :contadigito, 
                  ContaNumero = :contanumero, 
                  TipoConta = :tipoconta, 
                  BloquearRepasse = :bloquearrepasse,
                  MeioPagamento = :meiopagamento, 
                  TipoChave = :tipochave,
                  Pix = :chavepix,
                  CPFCNPJTerceiro = :cpfcnpjterceiro
              WHERE InfoID = :infoid;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":bancoid", $bancoID);
    $stmt->bindParam(":infoid", $infoID);
    $stmt->bindParam(":agencia", $agencia);
    $stmt->bindParam(":contadigito", $contaDigito);
    $stmt->bindParam(":contanumero", $contaNumero);
    $stmt->bindParam(":meiopagamento", $meioPagamento);
    $stmt->bindParam(":tipoconta", $tipoConta);
    $stmt->bindParam(":bloquearrepasse", $bloquearRepasse);
    $stmt->bindParam(":tipochave", $tipoChave);
    $stmt->bindParam(":chavepix", $chavePix);
    $stmt->bindParam(":cpfcnpjterceiro", $cpfcnpjTerceiro);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroEfetuado('consultarInformacoesBancarias');
    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;

    die();
}

//DELETE
function deleteData($pdo, $infoID) {

    $query = "DELETE FROM InformacoesBancarias WHERE InfoID = :infoid;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":infoid", $infoID);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroRemovido('consultarInformacoesBancarias');
    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;

    die();
}

//SET OTHER ACCOUNTS
function setOtherAccounts($pdo) {
    $condID = $_POST['condominio-id'];

    $query = "UPDATE InformacoesBancarias 
              SET TipoConta = 'Secundária'
              WHERE CondID = :condid AND TipoConta = 'Principal';";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condid", $condID);

    if ($stmt->execute()) {

    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;
}

