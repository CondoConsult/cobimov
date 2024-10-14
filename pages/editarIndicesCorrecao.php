<?php include_once '../public/partials/header.php'; ?>

<div class="wrapper">
    <h1>Editar Índices de Correção</h1>

    <?php
    include_once '../src/db_functions/select.php';

    $condFiltro = $_POST['edit'];

    $query = "SELECT Condominios.CondName, CondominiosIndCorrecao.* FROM CondominiosIndCorrecao 
              JOIN Condominios
              ON CondominiosIndCorrecao.CondID = Condominios.CondID
              WHERE CondominiosIndCorrecao.CondID = '$condFiltro';";
    $results = selectData($query);

    foreach ($results as $row) {
        $condominio = htmlspecialchars($row['CondName']);
        $indiceConvencao = htmlspecialchars($row['IndiceConvencao']);
        $indiceContrato = htmlspecialchars($row['IndiceContrato']);
        $indiceCond21 = htmlspecialchars($row['IndiceCond21']);
        $alteradoPara = htmlspecialchars($row['AlteradoPara']);
    }
    ?>
    
    <form action="../src/db_forms/indices_correcao.php" method="POST">
        <div class="containers">
            <div class="box">
                <?php echo "<h2>" . $condominio . "</h2>"; ?>
                <input type="hidden" name="condominio" value="<?php echo $condFiltro; ?>">
                <label for="">Índice Convenção</label><br>
                <input name="indice-convencao" type="text" value="<?php echo $indiceConvencao; ?>"><br>
                <label for="">Índice Contrato</label><br>
                <input name="indice-contrato" type="text" value="<?php echo $indiceContrato; ?>"><br>
                <label for="">Índice Cond21</label><br>
                <input name="indice-cond21" type="text" value="<?php echo $indiceCond21; ?>"><br>
                <label for="">Alterado para</label><br>
                <input name="alterado-para" type="text" value="<?php echo $alteradoPara; ?>">
            </div>
        </div>
        <div class="buttons-container">
            <button name="button" value="update" class="btn primary" type="submit">Salvar</button>
            <button name="button" value="delete" class="btn remove" type="submit">Remover</button>
            <a href="consultarIndicesCorrecao.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>
    </form>
</div>

</body>
</html>
