<?php include_once '../public/partials/header.php'; ?>

<div class="wrapper">
    <h1>Consultar Conciliação Bancária</h1>

    <form method="POST">
        <input type="date" name="date-filter">
        <button class="btn filter">Filtrar</button>
    </form>

    <?php
    require_once '../src/db_functions/select.php';

    $dateFilter = $_POST['date-filter'];

    if (!isset($dateFilter)) {
        $dateFilter = date("Ymd");         
    }

    $dateFilter = date("Ymd", strtotime($dateFilter));
    $dateTitle = date("d/m/Y", strtotime($dateFilter));

    echo "<h3>Extrato " . $dateTitle . "</h3>";

    $query = "SELECT CondName, ExtratoConciliacaoBancaria.* FROM ExtratoConciliacaoBancaria 
              LEFT JOIN Condominios ON Condominios.CondID = ExtratoConciliacaoBancaria.CondID
              WHERE DataTransferencia = $dateFilter
              ORDER BY StatusContasPagar ASC;";
    $results = selectData($query);

    $results = selectData($query);

    echo "<div class='table-container'>";
    echo "<table class='tables'>
            <tr>
                <th>Condominio</th>
                <th>Tipo Transferencia</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>";

    foreach ($results as $row) {
        $condominio = htmlspecialchars($row['CondName']);
        $tipoTransferencia = htmlspecialchars($row['TipoTransferencia']);
        $dataTransferencia = htmlspecialchars($row['DataTransferencia']);
        $Valor = htmlspecialchars($row['Valor']);
        $statusCP= htmlspecialchars($row['StatusContasPagar']);

        echo "<tr>";
        if (!empty($condominio)) {
            echo "<td>" . $condominio . "</td>";
        } else {
            echo "<td>?</td>";
        }
       
        echo "<td>" . $tipoTransferencia . "</td>";
        echo "<td>" . $dataTransferencia = date("d/m/Y", strtotime($dataTransferencia)) . "</td>";
        echo "<td>" . $Valor . "</td>";

        switch ($statusCP) {
            case 'Lançado':
                echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
                break;
            case 'Pendente':
                echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
                break;
        }

        echo "</tr>";
    }

    echo "</table></div>";
    ?>

    <div class="buttons-container">
        <a href="repasses.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
</div>

<script src="../js/main.js"></script>
</body>
</html>
