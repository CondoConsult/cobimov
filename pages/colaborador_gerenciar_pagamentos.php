<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';
?>

<div class="wrapper">

    <h1>Gerenciar Solicitacaos Pagamento Colaboradores</h1>

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
                <th>Solicitante</th>
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