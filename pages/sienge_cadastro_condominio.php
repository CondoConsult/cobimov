<?php include_once '../public/partials/header.php';?>

    <div class="wrapper">
        <div class="box">
        <h1>Gerenciar Infomações Condomínios Sienge</h1>

        <p>Apenas grupo Nova Casa</p>

            <?php 
            require_once '../src/filters/condominios_sienge.php'; 

                try {
                    require_once '../src/db/dbh.php';

                    $query = "SELECT * FROM CondominiosInfoSienge
                              RIGHT JOIN Condominios
                              ON CondominiosInfoSienge.CondID = Condominios.CondID
                              WHERE Condominios.CondID = '$condFiltro';";
                    $results = selectData($query);
        
                    foreach ($results as $row) {
                        $diasLiquidacao = htmlspecialchars($row['DiasLiquidacao']);
                        $condominio = htmlspecialchars($row['CondName']);
                        $conta = htmlspecialchars($row['Conta']);
                    }

                } catch (PDOException $error) {
                    die("Query failed: " . $error->getMessage());
                }

                if (!empty($condFiltro)) {
                    echo "<h2>" . $condominio . "</h2>";

            ?>

            <form action="../src/db_forms/sienge_condominios.php" method="POST">
                <input type="number" name="cond-id" value="<?php echo $condFiltro ?>" hidden><br>
                <label>Dias para liquidação</label><br>
                <input type="number" name="dias-liquidacao" value="<?php echo $diasLiquidacao ?>"><br>
                <label>Conta</label><br>
                <input type="text" name="conta" value="<?php echo $conta ?>">
                <div class="buttons-container">
                    <button name="button" class="btn primary" type="submit">Cadastrar</button>
                    <button name="button" value="delete" type="submit" class="btn remove">Remover</button>
             <?php } ?>       
                    <a href="sienge.php"><button class="btn secondary" type="button">Voltar</button></a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>