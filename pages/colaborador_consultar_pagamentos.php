<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';
?>

  <div class="wrapper">
  <div id="export-content">

    <h1>Consultar Pagamentos</h1>
    
<?php

  $query = "SELECT * FROM colaborador_pagamentos;";
  $results = selectData($query);

  echo "<div class='table-container'>
        <table class='tables'>
      <tr>
        <th>Data</th> 
        <th>Descricao</th>
        <th>Valor</th>
      </tr>";

  foreach ($results as $row) {
    $dataSolicitacao = htmlspecialchars($row['data_solicitacao']);
    $descricao = htmlspecialchars($row['descricao']);
    $valor = htmlspecialchars($row['valor']);
    $statusPagamento = htmlspecialchars($row['status_pagamento']);

    echo "<tr>";
    echo "<td>" . $dataSolicitacao . "</td>";
    echo "<td>" . $descricao . "</td>";
    echo "<td>" . $valor . "</td>";
    echo "<td>" . $statusPagamento . "</td>";
    echo "<tr>";

  }

  echo "</table></div>";

?>
  </div>

    <div class="buttons-container">
      <button class="btn primary" onclick="exportToPDF()">Exportar</button>
      <a href="colaborador_area"><button class="btn secondary" type="button">Voltar</button></a>
    </div>

  </div>

  <script src="../js/exportPDF.js"></script>
</body>
</html>