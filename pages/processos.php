<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Relatório Processos</h1>

    <?php
    require_once '../src/db_functions/select.php';

    $query = "SELECT DISTINCT(DataEnvio) FROM EnvioBoletos;";
    $dates = selectData($query);

    # Set date for initial filter
    $dateFilter = date('m/Y');
    $currentDay = date('d');

    if ($currentDay > 20) {
      $dateFilter = DateTime::createFromFormat('d/m/Y', "01/$dateFilter");
      $dateFilter->modify('+1 month');
      $dateFilter = $dateFilter->format('m/Y');
    }

    # Date filter options
    echo "<form method='POST' id='filtrar'>
          <label>Mês</label>
          <select name='date-filter' onchange='filtrar()'>
          <option>Selecione...</option>;";
    foreach ($dates as $row) {
        $date = $row['DataEnvio'];
        echo "<option value='$date'> $date </option>";
    }
    echo "</select></form>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $dateFilter = $_POST['date-filter'];
    }

    if (empty($dateFilter)) {
      require_once '../includes/messages/selecione_data.php';
    } else {

      echo "<h2>" . $dateFilter . "</h2>";

    $query = "SELECT CondName,EnvioBoletos.* FROM EnvioBoletos
              JOIN Condominios ON EnvioBoletos.CondID = Condominios.CondiD 
              WHERE DataEnvio = '$dateFilter' ORDER BY EnvioID DESC;";
    $results = selectData($query);

    echo "<div class='table-container'>";
    echo "<table class='tables'>"
          . "<tr>"
          . "<th>Condomínio</th>"
          . "<th>Carregamento Remessa</th>"
          . "<th>Rel. Receber por Unidade</th>"
          . "<th>Envio Comunicado</th>"
          . "<th>Boleto Segunda Via</th>"
          . "<th>Envio de Boletos</th>"
          . "</tr>";

          $comunicadosEnviados = 0;
          $remessasEnviadas = 0;
          $boletosEnviados = 0;
          $segundaViaExportados = 0;

    foreach ($results as $row) {
      $arquivoRemessa = $row['StatusRemessa'];
      $envioBoleto = $row['StatusEnvio'];
      $comunicado = $row['StatusComunicado'];
      $segundaVia = $row['StatusSegundaVia'];
      $relReceberUnidade = $row['RelReceberUnidade'];
      $condName = $row['CondName'];

      echo "<tr>";

      echo "<td>" . $condName . "</td>";

      # REMESSA
      switch ($arquivoRemessa) {
        case 'Enviado':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
          $remessasEnviadas++;
          break;
        default:
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
      }

      # REL RECEBR POR UNIDADE

      # COMUNICADO 
      switch ($relReceberUnidade) {
        case 'Exportado':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
          break;
        case 'Pendente':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
        default:
          echo "<td>N/A</td>";
          break;
      }

      # COMUNICADO 
      switch ($comunicado) {
        case 'Enviado':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
          $comunicadosEnviados++;
          break;
        case 'Pendente':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
        case 'Não encontrado':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/attention.svg'> " . $comunicado . "</td>";
          break;
        default:
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
      }

      # SEGUNDA VIA
      switch ($segundaVia) {
        case 'Exportado':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
          $segundaViaExportados++;
          break;
        case 'Pendente':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
        case 'Erro':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/attention.svg'>" . $segundaVia . "</td>";
          break;
        default:
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
      }

      # ENVIO BOLETOS
      switch ($envioBoleto) {
        case 'Enviado':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
          $boletosEnviados++;
          break;
        case 'Pendente':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
        case 'Nenhum registro':
          echo "<td><img class='processes-status-icons' src='../public/images/icons/attention.svg'> " . $envioBoleto . "</td>";
          break;
        default:
          echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
          break;
      }

      echo "<tr>";
    }

    echo "</table>";
    echo "</div>";

    echo "<p>Remessas enviadas:" . $remessasEnviadas . "</p>";
    echo "<p>Boletos enviados: " . $boletosEnviados . "</p>";
    echo "<p>Comunicados enviados: " . $comunicadosEnviados . "</p>";
    echo "<p>Segunda via exportados:" . $segundaViaExportados . "</p>";

    }
    ?>

  </div></div>

    <div class="buttons-container">
      <a href="home.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>


  <script src="../js/main.js"></script>

</body>
</html>
