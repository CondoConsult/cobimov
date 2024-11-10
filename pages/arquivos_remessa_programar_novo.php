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
          <input type="text" name="mes-referencia" required value="<?php echo $currentDate ?>">
            <div class="buttons-container">
              <button class="btn primary" type="submit" name="button" value="insert">Adicionar</button>
              <a href="arquivos_remessa_programar"><button class="btn secondary" type="button">Voltar</button></a>
            </div>
        </form>
    </div>

</body>
</html>