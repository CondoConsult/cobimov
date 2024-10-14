<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';


$currentDay = date('d');
$currentDate = date('m/Y');

if ($currentDay > 20) {
    $date = DateTime::createFromFormat('d/m/Y', "01/$currentDate");
    $date->modify('+1 month');
    $currentDate = $date->format('m/Y');
}

?>

  <div class="wrapper">
    <h1>Programar Arquivo Remessa</h1>
      <p>Adicione condomínios na fila para exportação automática de arquivos de remessa.</p>
        <form action="../src/db_forms/remessa.php" method="POST">
          <?php require_once '../src/selects/condominios_multi.php';?><br>
          <label>Mes de Referência</label><br>
          <input type="text" name="mes-referencia" required value="<?php echo $currentDate ?>"><br>
            <div class="buttons-container">
              <button class="btn primary" type="submit" name="button" value="insert">Adicionar</button>
            </div>
        </form>

  <?php
  $query = 'SELECT CondName, rpa_programar_remessa.* FROM rpa_programar_remessa
            JOIN Condominios ON rpa_programar_remessa.cond_id = Condominios.CondID ORDER BY estado DESC, id DESC;';
  $results = selectData($query);


  echo "<div class='table-container'>
        <table class='tables'>
      <tr>
          <th>Condomínio</th>
          <th>Mês de Referência</th>
          <th>Status</th>
          <th></th>
      </tr>";

  foreach ($results as $row) {
    $condID = $row['cond_id'];
    $condominio = $row['CondName'];
    $currentDate = $row['mes_referencia'];
    $estado = $row['estado'];

    echo "<tr>
            <td>" . $condominio . "</td>
            <td>" . $currentDate . "</td>";

            switch ($estado) {
              case 'Pendente':
                echo "<td><img class='processes-status-icons' src='../public/images/icons/pending.svg'></td>";
                echo "<form action='../src/db_forms/remessa.php' method='POST'>
                        <td>
                          <input  name ='condominio' value=" . $condID ." hidden>
                          <input  name ='mes-referencia' value=" . $currentDate ." hidden>
                          <button name='button' value='delete'><img class='processes-status-icons' src='../public/images/icons/trash.svg'></button>
                        </td>
                      </form>";
                break;
              case 'Exportado':
                echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
                echo "<td>-<td>";
                break;
            }

    echo "<tr>";
  }
  echo "</table></div>";
  ?>

    <div class="buttons-container">
      <a href="arquivos_remessa_consultar.php"><button class="btn primary" type="button">Consultar</button></a>
      <a href="arquivos_remessa.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>

  </div>

</body>
</html>