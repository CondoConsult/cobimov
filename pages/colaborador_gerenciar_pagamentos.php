<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';
?>

<div class="wrapper">

    <h1>Gerenciar Solicitacoes Pagamento Colaboradores</h1>

    <?php

    $query = "SELECT * FROM colaborador_pagamentos
              ORDER BY data_solicitacao DESC;";
    $requestBy = selectData($query);

    echo "<form method='POST'>
           <select name='solicitante'>";

    foreach ($requestBy as $row) {
      $solicitante = htmlspecialchars($row['solicitante']);
      echo "<option value='" . $solicitante . "'>" . $solicitante . "</option>";
    }

    echo "</select>
          <button class='btn filter'>Filtrar</button>
          </form>";

    $query = "SELECT * FROM colaborador_pagamentos
              ORDER BY data_solicitacao DESC;";
              $results = selectData($query);
                  
    echo "<div class='table-container'>
            <table class='tables'>
              <tr>
                <th>Data</th> 
                <th>Descrição</th>
                <th>Valor</th>
                <th>Solicitante</th>
                <th>Aprovar?</th>
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

        if ($statusPagamento === 'pendente') {
          echo "<td><form action='../src/db_forms/colaborador_pagamentos' method='POST'>
                      <input value='" . $pagamentoID . "' name='pagamento-id' hidden>
                      <button name='button' value='update'><i class='fa-regular fa-circle-check'></i></button>
                      <button name='button' value='update'><i class='fa-solid fa-xmark'></i></button>
                    </form>
                </td>";
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