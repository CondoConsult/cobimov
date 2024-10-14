<?php include_once '../public/partials/header.php';?>

<div class="wrapper">
    <h1>Consultar Avisos de Vencimento</h1>
    <p>Calendário de programação para envio de avisos de vencimento por e-mail.<br><br></p>

    <form method="POST">
        <button class="btn filter" name="filter" value="Hoje">Hoje</button>
        <button class="btn filter" name="filter" value="Enviado">Enviados</button>
        <button class="btn filter" name="filter" value="Pendente">Pendentes</button>
    </form>

    <?php
    if (!isset($_POST['filter'])) {
        $filter = 'Hoje';
    } else {
        $filter = $_POST['filter'];
    }

    include_once '../src/db_functions/select.php';

    $query = "SELECT AvisosVencimento.*, Condominios.CondName FROM AvisosVencimento 
              JOIN Condominios ON AvisosVencimento.CondID = Condominios.CondID";
    
    if ($filter === 'Hoje') {
        $filterDate = date('Y-m-d');
        $query .= " WHERE DataEnvio = '$filterDate'";
    } else {
        $query .= " WHERE StatusAtual = '$filter'";
    }
    
    $query .= " ORDER BY DataEnvio ASC, TipoEmail ASC;";
    $results = selectData($query);

    echo "<h2>" . $filter . "</h2>";

    if (empty($results)) {
        echo "<p>Nenhum registro programado para hoje.</p>"; 
    } else {
        echo "<div class='table-container'>";
        echo "<table class='tables'>
                <tr>
                    <th>Condomínio</th>
                    <th>Enviar no Dia</th>
                    <th>Data de Vencimento</th>
                    <th>Tipo E-mail</th>
                    <th>Status</th>
                </tr>";

        foreach ($results as $row) {
            $dataEnvio = strtotime($row['DataEnvio']);
            $dataVencimento = $row['DataVencimento'];
            $tipoEmail = $row['TipoEmail'];
            $statusAutal = $row['StatusAtual'];

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['CondName']) . "</td>";
            echo "<td>" . date('d/m', $dataEnvio) . "</td>";
            echo "<td>" . $dataVencimento . "</td>";

            switch ($tipoEmail) {
                case '02':
                    echo "<td>1 dia antes</td>";
                    break;
                case '04';
                    echo"<td>30 dias após</td>";
                    break;
                case '06';
                    echo"<td>110 dias após</td>";
                    break;
            }
 

            switch ($statusAutal) {
                case 'Enviado':
                    echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
                    break;
                case 'Pendente':
                    echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
                    break;
                case 'Nenhum registro':
                    echo "<td><i class='fa-solid fa-square'></i></td>";
                    break;
                default:
                    echo "<td>" . $statusAutal . "</td>";
                    break;
            }

            echo "</tr>";
        }
        echo "</table></div>";
    }
    ?>

    <div class="buttons-container">
        <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
</div>

</body>
</html>