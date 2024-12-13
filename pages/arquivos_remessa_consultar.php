<?php include_once '../public/partials/header.php';?>

<div class="wrapper">
    <h1>Arquivos Remessa</h1>
    <?php
    require_once '../src/db_functions/select.php';

    $currentYear = date('Y');

    $query = "SELECT DISTINCT(MesReferencia) FROM ArquivosRemessa WHERE MesReferencia LIKE '%$currentYear';";
    $months = selectData($query);

    echo "<form method='POST' id='filtrar' onchange='filtrar()'>
            <label>Mês</label>
            <input type='month' name='mes-referencia'>
        </form>";

        if (isset($_POST['mes-referencia'])) {
            $date = new DateTime($_POST['mes-referencia']);  // Create a DateTime object
            $mesReferencia = $date->format('m/Y');  // Format the date as MM/YYYY
        } else {
            
            $currentDay = date('d');
            $mesReferencia = date('m/Y');

            if ($currentDay > 20) {
                $date = DateTime::createFromFormat('d/m/Y', "01/$mesReferencia");
                $date->modify('+1 month');
                $mesReferencia = $date->format('m/Y');
            }
        }

        echo "<h2>" . $mesReferencia . "</h2>";
      
        $query = "SELECT Condominios.CondName, ArquivosRemessa.*, UnidadesRemessa.MesReferencia AS Mes,
                 UnidadesRemessa.BoletosExtras, UnidadesRemessa.BoletosUnicos, UnidadesRemessa.UnidadesBoletosUnicos,
                 CondominiosInfoAd.SindicoIsento, CondominiosInfoAd.Unidades
                 FROM ArquivosRemessa
                 JOIN Condominios ON ArquivosRemessa.CondID = Condominios.CondID
                 LEFT JOIN UnidadesRemessa ON ArquivosRemessa.CondID = UnidadesRemessa.CondID
                 AND ArquivosRemessa.MesReferencia = UnidadesRemessa.MesReferencia
                 LEFT JOIN CondominiosInfoAd ON UnidadesRemessa.CondID = CondominiosInfoAd.CondID
                 WHERE ArquivosRemessa.MesReferencia = '$mesReferencia'
                 ORDER BY ExportadoEm DESC;";
        $results = selectData($query);

        echo "<div class='table-container'>";
        echo "<table class='tables'>
            <tr>
                <th>Exportado em</th>
                <th>Mês</th>
                <th>Condomínio</th>
                <th>Banco</th>
                <th>Arquivo</th>
                <th>Boletos</th>
                <th>Calc.</th>
                <th>Carregamento</th>
            </tr>";

        foreach ($results as $row) {
            $unidades = $row['Unidades'];
            $sindicoIsento= $row['SindicoIsento'];
            $boletosExtras = $row['BoletosExtras'];
            $boletosUnicos = $row['BoletosUnicos'];
            $unidadesBoletosUnicos = $row['UnidadesBoletosUnicos'];
            $statusBB = $row['StatusBB'];

            if ($sindicoIsento == 'Sim') {
                $baseCustoOperacional = $unidades + $boletosExtras - 1;
            } else {
                $baseCustoOperacional = $unidades + $boletosExtras;
            }
            $total = $baseCustoOperacional + $boletosUnicos - $unidadesBoletosUnicos;

            echo "<tr>";
            echo "<td>" . date('d/m/Y - H:i', strtotime($row['ExportadoEm'])) . "</td>";
            echo "<td>" . $row['MesReferencia'] . "</td>";
            echo "<td>" . $row['CondName'] . "</td>";
            echo "<td>" . $row['BancoEmissao'] . "</td>";
            echo "<td>" . $row['Arquivo'] . "</td>";
            echo "<td>" . $row['NumeroBoletos'] . "</td>";

            if ($total == 0) {
                echo "<td> - </td>";
            } elseif ($row['NumeroBoletos'] == $total) {
                echo "<td><span class='span-green'>" . $total . "</span></td>";
            } else {
                echo "<td><span class='span-red'>" . $total . "</span></td>";
            }

            switch ($statusBB) {
                case 'Enviado':
                    echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
                    break;
                case 'Enviado anteriormente':
                    echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
                    break;
                case 'Pendente':
                    echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
                    break;
                case 'Arquivo não encontrado':
                    echo "<td><img class='processes-status-icons' src='../public/images/icons/file-minus.svg'></td>";
                    break;
            }
            echo "</tr>";
        }
        echo "</table></div>";
        ?>
    </div>

        <div class="buttons-container">
            <a href="arquivos_remessa_programar"><button class="btn primary" type="button">Programar</button></a>
            <a href="arquivos_remessa"><button class="btn secondary" type="button">Voltar</button></a>
        </div>

    <script src="../js/main.js"></script>
</body>
</html>