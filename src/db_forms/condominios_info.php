<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require_once '../db/dbh.php';

    $button= $_POST['button'];
    $condID = intval($_POST['cond-id']);

    switch ($button) {
        case 'update':
            checkData($pdo, $condID);
            updateData($pdo, $condID);   
            break;
        case 'delete':
            checkData($pdo, $condID);
            delete($pdo, $condID);
            break;
    }
}

function checkData($pdo, $condID) { // Check if condominio exists on db


    $query = "SELECT CondID FROM CondominiosInfoAd WHERE CondID = '$condID';";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) { // If the client doesn't exist insert a new client
        insertCond($pdo, $condID);
    }
}

function insertCond($pdo, $condID) { // Add condominio if it's not on db

    $query = "INSERT INTO CondominiosInfoAd (CondID) VALUES (:condominioid);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condominioid", $condID);

    if ($stmt->execute()) {

    } else {
      echo "error";
    }

    $pdo = null;
    $stmt = null; 
}

function updateData($pdo, $condID) {

    $administradora = $_POST['administradora'];
    $perfil = $_POST['perfil'];
    $unidades = intval($_POST['unidades']);
    $sindico = $_POST['sindico'];
    $sindicoTelefone = isset($_POST['telefone-sindico']) ? $_POST['telefone-sindico'] : array();
    $sindicoEmail = isset($_POST['email-sindico']) ? $_POST['email-sindico'] : array();
    $sindicoMorador = $_POST['sindico-morador'];
    $sindicoUnidade = $_POST['unidade-sindico'];
    $diaVencimento = isset($_POST['dia-vencimento']) ? $_POST['dia-vencimento'] : array();
    $taxaGarantidora = $_POST['taxa-garantidora'];
    $gas = $_POST['gas'];
    $agua = $_POST['agua'];
    $taxaBoletoValor = $_POST['taxa-boleto'];
    $diaRecebimentoRateio = intval($_POST['dia-rateio']);
    $grafica = $_POST['grafica'];
    $protocolo = $_POST['protocolo'];
    $demonstrativo = $_POST['demonstrativo'];
    $nomePorteiroZelador = isset($_POST['porteiro-zelador']) ? $_POST['porteiro-zelador'] : array();
    $telefonePorteiroZelador = isset($_POST['telefone-porteiro-zelador']) ? $_POST['telefone-porteiro-zelador'] : array();
    $primeiraCobranca = $_POST['primeira-cobranca'];
    $detalhesAntecipacao = $_POST['detalhes-antecipacao'];
    $antigaGarantidora = $_POST['antiga-garantidora'];
    $antigaGarantidoraTelefone = $_POST['antiga-garantidora-telefone'];
    $antigaGarantidoraEmail = $_POST['antiga-garantidora-email'];
    $antigaGarantidoraEndereco = $_POST['antiga-garantidora-endereco'];
    $observacoesGerais = $_POST['observacoes-gerais'];
    $fimContrato = $_POST['fim-contrato'];
    $formaEntrega = $_POST['forma-entrega'];
    $observacoesEntrega = $_POST['observacoes-entrega'];
    $avisosEmail = $_POST['avisos-email'];
    $envioBoletoEmail = $_POST['envio-boleto-email'];
    $sindicoIsento = $_POST['sindico-isento'];
    $sistema = $_POST['sistema'];
    $bancoEmissao = $_POST['banco-emissao'];
    $repasseTaxa = $_POST['repasse-taxa'];
    $repasseBoleto = $_POST['repasse-boleto'];

    $sindicoTelefone = implode(' - ' , $sindicoTelefone);
    $sindicoEmail = implode(' - ' , $sindicoEmail);
    $nomePorteiroZelador = implode(' - ' , $nomePorteiroZelador);
    $telefonePorteiroZelador = implode(' - ' , $telefonePorteiroZelador);
    $diaVencimento = implode(' - ' , $diaVencimento);

    $query = "UPDATE CondominiosInfoAd SET
             AdministradoraID = $administradora,
             Unidades = '$unidades',
             Perfil = '$perfil',
             Sindico = '$sindico',
             SindicoTelefone = '$sindicoTelefone',
             SindicoEmail = '$sindicoEmail',
             SindicoMorador = '$sindicoMorador',
             SindicoMoradorUnidade = '$sindicoUnidade',
             DiaVencimento = '$diaVencimento',
             TaxaGarantidora = '$taxaGarantidora',
             Gas = '$gas',
             Agua = '$agua',
             TaxaBoletoValor = '$taxaBoletoValor',
             DiaRecebimentoRateio = '$diaRecebimentoRateio',
             Grafica = '$grafica',
             Protocolo = '$protocolo',
             Demonstrativo = '$demonstrativo',
             PorteiroZeladorNome = '$nomePorteiroZelador',
             PorteiroZeladorTelefone = '$telefonePorteiroZelador',
             DataPrimeiraCobranca = '$primeiraCobranca',
             DetalhesAntecipacao = '$detalhesAntecipacao',
             AntigaGarantidora = '$antigaGarantidora',
             AntigaGarantidoraTelefone = '$antigaGarantidoraTelefone',
             AntigaGarantidoraEmail = '$antigaGarantidoraEmail',
             AntigaGarantidoraEndereco = '$antigaGarantidoraEndereco',
             ObservacoesGerais = '$observacoesGerais',
             FimContrato = '$fimContrato',
             FormaEntrega = '$formaEntrega',
             ObservacoesEntrega = '$observacoesEntrega',
             AvisosEmail = '$avisosEmail',
             EnviarBoletoEmail = '$envioBoletoEmail',
             SindicoIsento = '$sindicoIsento',
             Sistema = '$sistema',
             BancoEmissao = '$bancoEmissao',
             DescRepasseTaxa = '$repasseTaxa',
             DescRepasseBoleto = '$repasseBoleto'
             WHERE CondID = $condID;";

    $stmt = $pdo->prepare($query);

    if ($stmt->execute()) {
       include_once '../../public/partials/messages.php';
       cadastroEfetuado('consultarCondominio');
    } else {
       echo "error";
    }
  
    $pdo = null;
    $stmt = null;
}    

function delete($pdo, $condID) {
    $query = "DELETE FROM CondominiosInfoAd WHERE CondID = :condominioid;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":condominioid", $condID);

    if ($stmt->execute()) {
      include_once '../../public/partials/messages.php';
      cadastroRemovido('consultarCondominio');
    } else {
      echo "error";
    }

    $pdo = null;
    $stmt = null; 
}