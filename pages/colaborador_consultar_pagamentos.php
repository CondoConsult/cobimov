<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';
?>

<div class="wrapper">
  <div id="export-content">

    <h1>Consultar Pagamentos</h1>

    <form method="POST">
      <label>Data inicial</label><br>
      <input type="date" name="data-inicial"><br>
      <label>Data final</label><br>
      <input type="date" name="data-final">
      <button class="btn filter">Filtrar</button>
    </form>

    <?php

    $dataInicial = isset($_POST['data-inicial']) && $_POST['data-inicial'] ? $_POST['data-inicial'] : date('Y-m-01');
    $dataFinal = isset($_POST['data-final']) && $_POST['data-final'] ? $_POST['data-final'] : date('Y-m-d');

    echo "<h3>" . date('d/m/Y', strtotime($dataInicial)) . " a " . date('d/m/Y', STRTOTIME($dataFinal)) . "</h3>";

    $query = "SELECT * FROM colaborador_pagamentos
              WHERE data_solicitacao BETWEEN '$dataInicial' AND '$dataFinal' ORDER BY data_solicitacao DESC;";
    $results = selectData($query);

    echo "<div class='table-container'>
            <table class='tables'>
              <tr>
                <th>Data</th> 
                <th>Descrição</th>
                <th>Valor</th>
                <th>Status</th>
                <th></th>
              </tr>";

    foreach ($results as $row) {
        $dataSolicitacao = date('d/m/Y', strtotime(htmlspecialchars($row['data_solicitacao'])));
        $descricao = htmlspecialchars($row['descricao']);
        $valor = htmlspecialchars($row['valor']);
        $statusPagamento = htmlspecialchars($row['status_pagamento']);
        $pagamentoID = htmlspecialchars($row['pagamento_id']);

        echo "<tr>";
        echo "<td>" . $dataSolicitacao . "</td>";
        echo "<td>" . $descricao . "</td>";
        echo "<td>" . $valor . "</td>";

        switch ($statusPagamento) {
          case 'pendente':
            echo "<td><i class='fa-regular fa-clock'></i></td>";
            echo "<td><form action='../src/db_forms/colaborador_pagamentos' method='POST'>
                        <input value='" . $pagamentoID . "' name='pagamento-id' hidden>
                        <button name='button' value='delete'><i class='fa-regular fa-trash-can'></i></button>
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
        echo "</tr>";
    }

    echo "</table></div>";
    ?>

  </div>

  <div class="buttons-container">
    <a href="colaborador_solicitar_pagamento"><button class="btn primary">Solicitar</button></a>
    <button class="btn primary" onclick="exportToPDF()">Exportar</button>
    <a href="colaborador_area"><button class="btn secondary" type="button">Voltar</button></a>
  </div>

</div>

<script src="../js/exportPDF.js"></script>
</body>
</html>