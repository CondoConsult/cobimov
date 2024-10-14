<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../public/partials/header.php';?>

<div class="wrapper">
  <h1>Editar Repasse</h1>

  <?php

  # Edit record
  function editRepasse() {
    try {
      include "../src/db/dbh.php";

      $repasseID = $_POST['edit'];

      $query = "SELECT * FROM RepassesProgramados 
                JOIN InformacoesBancarias
                ON RepassesProgramados.CondID = InformacoesBancarias.CondID
                LEFT JOIN Bancos
                ON InformacoesBancarias.BancoID = Bancos.BancoID
                JOIN Condominios
                ON RepassesProgramados.CondID = Condominios.CondID
                WHERE RepasseID = :repasseid AND TipoConta = 'Principal';";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(":repasseid", $repasseID);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($results as $row) {
        $valor = htmlspecialchars($row["Valor"]);
        $dataPagamento = htmlspecialchars($row["DataPagamento"]);
        $categoria = htmlspecialchars($row["Categoria"]);
        echo "<h2>" .  htmlspecialchars($row["CondName"]) . "</h2>";
        if ($row['MeioPagamento'] == 'TED/DOC') {
          echo "<label>Banco</label><p>" .  htmlspecialchars($row["BancoID"]) . " - " . htmlspecialchars($row["BancoNome"]) . "</p>";
          echo "<label>Agência</label><p>" . htmlspecialchars($row["Agencia"]) . "</p>";
          echo "<label>Conta</label><p>" . htmlspecialchars($row["ContaNumero"]) . "-". $row["ContaDigito"] . "</p>";
        } else {
          echo "<label>Chave Pix</label><p>" . htmlspecialchars($row['Pix']) . "</p>";
        }
      } ?>
      <form method="post" action="../src/db_forms/repasse.php" >
        <div class="containers">
          <div class="box">
            <input type="text" name="repasse-id" value="<?php echo $repasseID ?>" hidden> <br>
            <label>Valor</label><br>
            <input name="valor" type="number" step="0.01" min="0.00" value="<?php echo $valor ?>" required><br>
            <label>Data de pagamento</label><br>
            <input name="data-pagamento" type="date" value="<?php echo $dataPagamento ?>"><br>
            <label>Categoria</label><br>
            <select name="categoria">
              <option value="Primeiro" <?php echo (trim($categoria) === 'Primeiro') ? 'selected' : '';?>>Primeiro</option>
              <option value="Segundo" <?php echo (trim($categoria) === 'Segundo') ? 'selected' : '';?>>Segundo</option>
              <option value="Terceiro" <?php echo (trim($categoria) === 'Terceiro') ? 'selected' : '';?>>Terceiro</option>
              <option value="Antecipação" <?php echo (trim($categoria) === 'Antecipação') ? 'selected' : '';?>>Antecipação</option>
              <option value="Retroativos" <?php echo (trim($categoria) === 'Retroativos') ? 'selected' : '';?>>Retroativos</option>
            </select>
          </div>
        </div>
        <div class="buttons-container">
          <button name="button" value="update" class="btn primary"  type="submit">Salvar</button>
          <button name="button" value="delete" class="btn remove" type="submit">Remover</button>
          <a href="consultarRepasses.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>
      </form> 
  <?php
    } catch (PDOException $error) {
        die("Query failed" . $error->getMessage());
    }
  }  

  # Revert record state
  function revertState() {
    try {
        include "../src/db/dbh.php";
        $repasseID = $_POST['revert'];

        $query = "UPDATE RepassesProgramados
                  SET Etapa = 'pendente'
                  WHERE RepasseID = :repasseid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('repasseid', $repasseID);

        if ($stmt->execute()) {
            echo "<script>
                     alert('Cadastro definido como pendente.');
                     window.location.href = '../pages/consultarRepasses.php';
                  </script>";
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

  # set record as done
  function setAsDone() {
    try {
        include "../src/db/dbh.php";
        $repasseID = $_POST['done'];

        $query = "UPDATE RepassesProgramados
                  SET Etapa = 'lançado'
                  WHERE RepasseID = :repasseid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('repasseid', $repasseID);

        if ($stmt->execute()) {
            echo "<script>
                     alert('Cadastro definido como lançado.');
                     window.location.href = '../pages/consultarRepasses.php';
                  </script>";
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

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    # Check what button was pressed
    if (isset($_POST['edit'])) { 
      editRepasse();
    } elseif (isset($_POST['revert'])) {
      revertState();
    } elseif (isset($_POST['done'])) {
      setAsDone();
    }
  } else {
    header("Location: home.php");
    exit;
  }
  ?>

</div>

</body>
</html>
