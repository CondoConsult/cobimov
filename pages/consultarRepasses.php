<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Consultar Repasses</h1>

    <form method="POST">
      <?php require_once '../src/selects/mes_referencia.php';?>
      <select name="filter" required>
        <option value="">Selecione...</option>
        <option value="pendente">Pendente</option>
        <option value="lançado">Lançado</option>
      </select>
      <button class="btn filter">Filtrar</button>
    </form>

    <?php

    if (isset($_POST['filter']) || isset($_POST['mes-referencia'])) {
      $statusFilter = $_POST['filter'];
      $mesReferencia = $_POST['mes-referencia'];
    } else {
      $statusFilter = "pendente";
      $mesReferencia = date('Y-m');
    }

    if (!empty($statusFilter)) {
      
        echo "<h2>Registros " . $statusFilter . "s " . date('m/Y', strtotime($mesReferencia)) . "</h2>";

        try {
      
          include '../src/db/dbh.php';

          $query = "SELECT * FROM RepassesProgramados
                    RIGHT JOIN Condominios ON Condominios.CondID = RepassesProgramados.CondID
                    LEFT JOIN InformacoesBancarias ON InformacoesBancarias.CondID = RepassesProgramados.CondID
                    WHERE RepassesProgramados.Etapa = :etapa 
                    AND TipoConta = 'Principal'
                    AND DataPagamento LIKE '%$mesReferencia%'
                    ORDER BY CadastradoEm DESC";

          $stmt = $pdo->prepare($query);
          $stmt->bindParam(":etapa", $statusFilter);
          $stmt->execute();

          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

          echo "<div class='table-container'>";
          echo "<table class='tables'>"
                . "<tr>"
                . "<th>Cadastrado em</th>"
                . "<th>Condomínio</th>"
                . "<th>Data Pagamento</th>"
                . "<th>Valor</th>"
                . "<th>Meio de Pagamento</th>"
                . "<th></th>"
                . "<th></th>"
                . "</tr>";

          echo "<form action='editar_repasse.php' method='POST'>";      
          foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . date('d/m/Y - H:i', strtotime($row['CadastradoEm'])) . "</td>";
            echo "<td>" . htmlspecialchars($row["CondName"]) . "</td>";
            echo "<td>" . date('d/m/Y', strtotime($row['DataPagamento'])) . "</td>";
            echo "<td>R$ " . number_format($row["Valor"], 2, ',', '.') . "</td>";
            echo "<td>" . htmlspecialchars($row["MeioPagamento"]) . "</td>"; 
            if ($row['Etapa'] == "pendente") {
              echo "<td><button value='". htmlspecialchars($row['RepasseID']) ."' name='done'><img class='processes-status-icons' src='../public/images/icons/done.svg'></button></td>";
              echo "<td><button value='". htmlspecialchars($row['RepasseID']) ."' name='edit'><img class='processes-status-icons' src='../public/images/icons/edit.svg'></button></td>";
            } else {
              echo "<td><button value='". htmlspecialchars($row['RepasseID']) ."' name='revert'><img class='processes-status-icons' src='../public/images/icons/previous.svg'/></button></td>";
            }
            echo "<tr>";
          }
          echo "</form>";
          echo "</table>";
          echo "</div>";

          $pdo = null;
          $stmt = null;

        } catch (PDOException $error) {
          die("Query failed: " . $error->getMessage());
        }
    
    } else {
      echo "<div class='select-filter'><p> 👆 Por favor, selecione uma opção.</p></div>";
    }
  ?>

    <div class="buttons-container">
      <a href="programarRepasse.php"><button type="button" class="btn primary">Novo</button></a>
      <a href="repasses.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
  </div>

</body>
</html>
