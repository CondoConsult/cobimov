<?php include_once '../public/partials/header.php';?>

    <div class="wrapper">
        <h1>Editar Número de Boletos</h1>

        <?php

        require_once '../src/db_functions/select.php';

        $mesReferencia = $_POST['mes-referencia'];
        $condominioID = $_POST['condominio-id'];
  
        if (empty($condominioID)) {
            require_once '../includes/messages/selecione_condominio.php';
        } else {

            $query = "SELECT UnidadesRemessa.*, Condominios.CondName FROM UnidadesRemessa
            RIGHT JOIN Condominios ON UnidadesRemessa.CondID = Condominios.CondID
            WHERE Condominios.CondID = $condominioID AND (UnidadesRemessa.MesReferencia = '$mesReferencia' OR UnidadesRemessa.MesReferencia IS NULL);";
            $unidadesRemessa = selectData($query);

            foreach ($unidadesRemessa as $row) {
                $boletosExtras = htmlspecialchars($row['BoletosExtras']);
                $boletosUnicos = htmlspecialchars($row['BoletosUnicos']);
                $unidadesBoletosUnicos = htmlspecialchars($row['UnidadesBoletosUnicos']);
            }

            $query = "SELECT Unidades, SindicoIsento, Condominios.CondName FROM CondominiosInfoAd
                      JOIN Condominios ON CondominiosInfoAd.CondID = Condominios.CondID
                      WHERE CondominiosInfoAd.CondID = $condominioID;";
            $condominios = selectData($query);

            foreach ($condominios as $row) {
                $numeroUnidades = htmlspecialchars($row['Unidades']);
                $sindicoIsento = htmlspecialchars($row['SindicoIsento']);
                $condName = htmlspecialchars($row['CondName']);
            }

            echo "<h2>" . $condName . "</h2>
                  <label>Mês de Referência</label>
                  <p>" . $mesReferencia . "</p>
                  <label>Numero de Unidades</label>
                  <p>" . $numeroUnidades . "</p>
                  <label>Sindico Isento?</label>
                  <p>" . $sindicoIsento . "</p>";

        ?>

            <form action="../src/db_forms/numero_boletos.php" method="POST">
                <input type="text" name="CondID" value="<?php echo $condominioID ?>" hidden>
                <input type="text" name="MesReferencia" value="<?php echo $mesReferencia ?>" hidden>
                <input type="text" name="table-name" value="UnidadesRemessa" hidden>
                <label>Boletos Extras</label><br>
                <input type="number" name="BoletosExtras" value="<?php echo $boletosExtras ?>"><br>
                <label>Boletos Unicos</label><br>
                <input type="number" name="BoletosUnicos" value="<?php echo $boletosUnicos ?>"><br>
                <label>Unidades Boletos Unicos</label><br>
                <input type="number" name="UnidadesBoletosUnicos" value="<?php echo $unidadesBoletosUnicos ?>"><br>
                <div class="buttons-container">
                    <button class="btn primary" name="button" value="insert" type="submit">Salvar</button>
                    <button class='btn remove' name='button' value='delete' type='submit'>Remover</button>
                    <a href="numero_boletos.php"><button class="btn secondary" type="button">Voltar</button></a>
                </div>
            </form>
        <?php } ?>
    </div>

</body>

</html>