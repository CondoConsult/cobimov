<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';
?>

<div class="wrapper">

    <h1>Gerenciar Solicitacoes Pagamento Colaboradores</h1>

    <?php

    $query = "SELECT DISTINCT(solicitante) FROM colaborador_pagamentos
              ORDER BY data_solicitacao DESC;";
    $requestBy = selectData($query);

    echo "<form method='POST'>
          <label>Solicitante</label><br>
          <select name='solicitante' required>";
    foreach ($requestBy as $row) {
      $solicitante = htmlspecialchars($row['solicitante']);
      echo "<option value='" . $solicitante . "'>" . $solicitante . "</option>";
    }
    echo "</select><br>";
    ?>
      <label>Status</label><br>
      <select name="status" required>
        <option value="Pendente">Pendente</option>
        <option value="Negado">Negado</option>
        <option value="Aprovado">Aprovado</option>
        <option value="Pago">Pago</option>
      </select>
      <button class='btn filter'>Filtrar</button>
    </form>

    <?php

    $solicitanteFiltro = isset($_POST['solicitante']) && $_POST['solicitante'] ? $_POST['solicitante'] : '';
    $statusFiltro = isset($_POST['status']) && $_POST['status'] ? $_POST['status'] : 'Pendente';

    $query = "SELECT * FROM colaborador_pagamentos
              WHERE (solicitante = '$solicitanteFiltro' OR '$solicitanteFiltro' = '')
              AND status_pagamento = '$statusFiltro'
              ORDER BY data_solicitacao DESC;";
              $results = selectData($query);

    echo "<h3>" . $statusFiltro . "</h3>";
                  
    echo "<div class='table-container'>
            <table class='tables'>
              <tr>
                <th>Data</th> 
                <th>Descrição</th>
                <th>Valor</th>
                <th>Solicitante</th>
                <th>" . $statusFiltro . "?</th>
              </tr>";

    foreach ($results as $row) {
        $dataSolicitacao = date('d/m/Y', strtotime(htmlspecialchars($row['data_solicitacao'])));
        $descricao = htmlspecialchars($row['descricao']);
        $valor = htmlspecialchars($row['valor']);
        $statusPagamento = htmlspecialchars($row['status_pagamento']);
        $solicitante = htmlspecialchars($row['solicitante']);
        $pagamentoID = htmlspecialchars($row['pagamento_id']);

        echo "<tr>";
        echo "<td>" . $dataSolicitacao . "</td>";
        echo "<td>" . $descricao . "</td>";
        echo "<td>" . $valor . "</td>";
        echo "<td>" . $solicitante . "</td>";

        switch ($statusPagamento) {
          case 'pendente':
            echo "<td><form action='../src/db_forms/colaborador_pagamentos' method='POST'>
            <input value='" . $pagamentoID . "' name='pagamento-id' hidden>
            <button name='button' value='approve'><i class='fa-regular fa-circle-check'></i></button>
            <button name='button' value='deny'><i class='fa-solid fa-xmark'></i></button>
            </form>
            </td>";
            break;

          case 'aprovado':
            echo "<td><i class='fa-regular fa-clock'></i><i class='fa-solid fa-robot'></i></td>";
          break;
          
          case 'negado':
            echo "<td><i class='fa-solid fa-ban'></i></td>";
          break;
  
          case 'pago':
            echo "<td><i class='fa-solid fa-check'></i></td>";
          break;
        }
        if ($statusPagamento === 'pendente') {

        }
        echo "</tr>";
    }

    echo "</table></div>";
    ?>

  <div class="buttons-container">
    <a href="colaborador_area"><button class="btn secondary" type="button">Voltar</button></a>
  </div>

</div>

</body>
</html>