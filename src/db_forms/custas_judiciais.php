<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  require_once '../db/dbh.php';

  $button = $_POST["button"];

  switch ($button) {
    case 'insert':
        insertData($pdo);
        break;
    case 'update':
        updateData($pdo);
        break;
    case 'delete':
        deleteData($pdo);
        break;         
  }

} else {
  header("Location: ../../pages/home.php");
  exit;    
}

//INSERT
function insertData($pdo) {
  try {
      $condominio = $_POST['condominio'];
      $unidade = $_POST['unidade'];
      $classe = $_POST['classe'];
      $valor = $_POST['valor'];
      $dataPagamento = $_POST['data-pagamento'];
      $linhaDigitavel = $_POST['linha-digitavel']; 
      $responsavel = $_POST['responsavel'];  
      $nomeProprietario = $_POST['nome-proprietario']; 
      $descricao = $_POST['descricao'];
      $opcoesLancamento = $_POST['opcoes-lancamento'];

      $query = "INSERT INTO LancamentosCJudiciais 
          (CondID, Unidade, Classe, Valor, DataPagamento, LinhaDigitavel, 
          Responsavel, NomeProprietario, Descricao, Etapa, EtapaContasPagar,
          EtapaContasReceber, EtapaBB, opcoes_lancamento)
          VALUES 
          (:condominio, :unidade, :classe, :valor, :datapagamento,
          :linhadigitavel, :responsavel, :nomeproprietario, :descricao,
          'pendente', 'pendente', 'pendente', 'pendente', :opcoeslancamento);";

      $stmt = $pdo->prepare($query);
      $stmt->bindParam(":condominio", $condominio);
      $stmt->bindParam(":unidade", $unidade);
      $stmt->bindParam(":classe", $classe);
      $stmt->bindParam(":valor", $valor);
      $stmt->bindParam(":datapagamento", $dataPagamento);
      $stmt->bindParam(":linhadigitavel", $linhaDigitavel);
      $stmt->bindParam(":responsavel", $responsavel);
      $stmt->bindParam(":nomeproprietario", $nomeProprietario);
      $stmt->bindParam(":descricao", $descricao);
      $stmt->bindParam(":opcoeslancamento", $opcoesLancamento);
      
      if ($stmt->execute()) {
          include_once '../../public/partials/messages.php';
          cadastroEfetuado('consultarCustasJudiciais');
      } else {
          echo "Error: Unable to execute the insert query.";
      }
      
      $stmt = null; 
  } catch (PDOException $error) {
      die("Query failed: " . $error->getMessage());
  }
}

//UPDATE
function updateData($pdo) {
  try {
    $custaID = $_POST["custa-id"];
    $unidade = $_POST["unidade"];
    $nomeProprietario = $_POST["nome-proprietario"];
    $linhaDigitavel = $_POST["linha-digitavel"];
    $valor = $_POST["valor"];
    $dataPagamento = $_POST["data-pagamento"];
    $responsavel = $_POST["responsavel"];
    $descricao = $_POST["descricao"];
    $opcoesLancamento = $_POST['opcoes-lancamento'];

    $query = "UPDATE LancamentosCJudiciais
              SET 
              Valor = :valor,
              DataPagamento = :datapagamento,
              LinhaDigitavel = :linhadigitavel,
              Responsavel = :responsavel,
              NomeProprietario = :nomeproprietario,
              Descricao = :descricao,
              Unidade = :unidade,
              opcoes_lancamento = :opcoeslancamento
              WHERE CustaID = :custaid;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":custaid", $custaID);
    $stmt->bindParam(":unidade", $unidade);
    $stmt->bindParam(":valor", $valor);
    $stmt->bindParam(":datapagamento", $dataPagamento);
    $stmt->bindParam(":linhadigitavel", $linhaDigitavel);
    $stmt->bindParam(":responsavel", $responsavel);
    $stmt->bindParam(":nomeproprietario", $nomeProprietario);
    $stmt->bindParam(":descricao", $descricao);
    $stmt->bindParam(":opcoeslancamento", $opcoesLancamento);
    $stmt->execute();

    if ($stmt->execute()) {
      include_once '../../public/partials/messages.php';
      cadastroAtualizado('consultarCustasJudiciais');
    } else {
      echo "error";
    }

    $pdo = null;
    $stmt = null; 

  } catch (PDOException $error) {
    die("Query failed: " . $error->getMessage());
  }
}

function deleteData($pdo) {

  try {
    $custaID = $_POST["custa-id"];

    $query = "DELETE FROM LancamentosCJudiciais WHERE CustaID = :custaid;";
    $stmt= $pdo->prepare($query);
    $stmt->bindParam(":custaid", $custaID);
    $stmt->execute();

    if ($stmt->execute()) {
      include_once '../../public/partials/messages.php';
      cadastroRemovido('consultarCustasJudiciais');;
    } else {
      echo "error";
    }

    $pdo = null;
    $stmt = null; 

  } catch (PDOException $error) {
    die("Query failed: " . $error->getMessage());
  }
}