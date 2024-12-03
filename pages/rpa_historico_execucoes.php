<?php include_once '../public/partials/header.php';?>

<div class="wrapper">
    <h1>Histórico de Execuções</h1>

    <?php

        require_once '../src/db_functions/select.php';

        if ($accountType === 'APS' ) {
            $client = 'APS';
        } else {
            $client = 'Condo Consult';
        }

        $query = "SELECT DISTINCT(processo) FROM rpa_historico_execucoes 
                  WHERE cliente = '$client' ORDER BY processo ASC;";
        $processos = selectData($query); ?>

        <form method="POST">
            <select name="processo-filtro">
                <?php
                foreach ($processos as $row) {
                    $processo = $row['processo'];?>  
                        <option value="<?php echo $processo ?>"><?php echo $processo ?></option>
                <?php } ?>
            </select>
            <button class="btn filter">Filtrar</button>
        
        <?php
        $processo = $_POST['processo-filtro'];
        $currentDate = date('M d');

        echo "<h2>" . htmlspecialchars($processo) . "</h2>";

        $query = "SELECT * FROM rpa_historico_execucoes
                  WHERE (processo = '$processo' OR '$processo' IS NULL OR '$processo' = '')
                  AND cliente = '$client' 
                  ORDER BY id_execucao DESC LIMIT 100;";
        $results = selectData($query);

        foreach ($results as $row) {
            $processo = $row['processo'];
            $maquina = $row['maquina'];
            $processo_log = $row['processo_log'];
            $dataExecucao = $row['data_execucao'];
            $horaExecucao = $row['hora_execucao'];
            $duracao = $row['duracao'];

            echo "<div class='containers'>";

            if($dataExecucao == $currentDate) {
                echo "<div class='home-box' style='border: solid 1.5px #66cc85;'>"; 
            } else {
                echo "<div class='home-box'>";
            }

            echo "<h3>" . htmlspecialchars($processo) . "</h3>";
            echo "<p><span class='highlight-green'>" . htmlspecialchars($dataExecucao) . " " . htmlspecialchars($horaExecucao) . " - " . htmlspecialchars($duracao) . "</span></p>";
            
            if (!empty($processo_log)) {
                echo "<details><summary>Log</summary><p>" . $processo_log . "</p></details>";
            } else {
                echo "<details><summary>Log</summary><p>Success.</p></details>";
            }

            echo "<p><span style='color:#000; background: #66cc85; border-radius: 5px; padding: 5px; font-size: 0.7rem;'>" . htmlspecialchars($maquina) . "</p>";
            echo "</div></div>";
        }
    ?>
</div>

</body>
</html>
