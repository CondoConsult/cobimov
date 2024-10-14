<?php include_once '../public/partials/header.php';?>

<div class="wrapper">
    <h1>Consultar Custas Judiciais</h1>

    <form method="POST">
        <?php require_once '../src/selects/mes_referencia.php'; ?>
        <select name="filter" required>
            <option value="">Selecione...</option>
            <option value="pendente">Pendente</option>
            <option value="lançado">Lançado</option>
        </select>
        <button class="btn filter">Filtrar</button>
    </form>

    <?php
    if (isset($_POST['filter']) || isset($_POST['mes-referencia'])) {
        $etapa = $_POST['filter'];
        $mesReferencia = $_POST['mes-referencia'];
    } else {
        $etapa = "pendente";
        $mesReferencia = date('Y-m');
    }

    if (!empty($etapa)) {
        echo "<h2>Registros " . htmlspecialchars($etapa) . "s " . date('m/Y', strtotime($mesReferencia)) . "</h2>";
        
        try {
            require_once '../src/db_functions/select.php';

            $query = "SELECT * FROM LancamentosCJudiciais
                      JOIN Condominios ON Condominios.CondID = LancamentosCJudiciais.CondID
                      WHERE Etapa = '$etapa'
                      AND DataPagamento LIKE '%$mesReferencia%'
                      ORDER BY CadastradoEm DESC";

            $results = selectData($query);

            echo "<div class='table-container'>";
            echo "<table class='tables'>
                    <tr>
                        <th>CP</th>
                        <th>CR</th>
                        <th>BB</th>
                        <th>Condomínio</th>
                        <th>Unidade</th>
                        <th>Pagamento</th>
                        <th>Classe</th>
                        <th>Descrição</th>
                        <th>Linha Digitável</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>";

            echo "<form action='editarCustasJudiciais.php' method='post'>";      
            foreach ($results as $row) {
                echo "<tr>";

                echo "<td><img class='processes-status-icons' src='../public/images/icons/" . ($row['EtapaContasPagar'] != "lançado" ? "pending.svg" : "done.svg") . "'></td>";
                echo "<td><img class='processes-status-icons' src='../public/images/icons/" . ($row['EtapaContasReceber'] != "lançado" ? "pending.svg" : "done.svg") . "'></td>";
                echo "<td><img class='processes-status-icons' src='../public/images/icons/" . ($row['EtapaBB'] != "lançado" ? "pending.svg" : "done.svg") . "'></td>";
                echo "<td>" . htmlspecialchars($row["CondName"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Unidade"]) . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($row['DataPagamento'])) . "</td>";
                echo "<td>" . htmlspecialchars($row["Classe"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Descricao"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["LinhaDigitavel"]) . "</td>";
                echo "<td>" . number_format($row["Valor"], 2, ',', '.') . "</td>";

                if ($row['Etapa'] == "pendente") {
                    echo "<td><button value='" . htmlspecialchars($row['CustaID']) . "' name='custa-id'><img class='processes-status-icons' src='../public/images/icons/edit.svg'></button></td>";
                }
                echo "</tr>";
            }
            echo "</form>";
            echo "</table>";
            echo "</div>";

        } catch (PDOException $error) {
            die("Query failed: " . $error->getMessage());
        }
    } else {
        echo "<div class='select-filter'><p>👆 Por favor, selecione uma opção.</p></div>";
    }
    ?>

    <div class="buttons-container">
        <a href="lancarCustasJudiciais.php"><button class="btn primary" type="button" >Novo</button></a>
        <a href="custasJudiciais.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
</div>

</body>
</html>