<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Consultar Índices de Correção</h1>

    <?php
    include_once '../src/db_functions/select.php';
    include_once '../src/filters/condominios.php';

    $query = "SELECT * FROM CondominiosIndCorrecao
              JOIN Condominios
              ON CondominiosIndCorrecao.CondID = Condominios.CondID
              WHERE Condominios.CondID = '$condFiltro';";
    $results = selectData($query);

      if (!empty($results)) { ?>
        <form action="editarIndicesCorrecao.php" method="POST">
          <button class="button-edit" name="edit" value="<?php echo $condFiltro;?>">Editar</button><br><br>
        </form>
      
      <?php
        foreach ($results as $row) {
          echo "<h2>" . $row['CondName'] . "</h2>";
        }
        echo "<table class='tables'>"
          . "<tr>"
              . "<th>Convenção</th>"
              . "<th>Contrato</th>"
              . "<th>Cond21</th>"
              . "<th>Alterado para</th>"
          . "</tr>";
        foreach ($results as $row) {
          echo  "<tr>"
              . "<td>" . $row['IndiceConvencao'] . "</td>" 
              . "<td>" . $row['IndiceContrato'] . "</td>" 
              . "<td>" . $row['IndiceCond21'] . "</td>" 
              . "<td>" . $row['AlteradoPara'] . "</td>" 
              . "</tr>";
        }
        echo "</table>";
      }
    ?>

</div>

    <div class="buttons-container">
      <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>


</body>
</html>
