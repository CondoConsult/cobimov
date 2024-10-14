<?php include_once '../public/partials/header.php';?>
  <main>
    <div class="wrapper">
      <div class="containers">
        <div class="home-box">
          <h2>Geral</h2>
          <a href="arquivos_remessa">Remessa</a><br>
          <a href="administradoras">Administradoras</a><br>
          <a href="condominios">Condomínios</a><br>
          <!-- <a href="sienge">Sienge</a><br> -->
        </div>
        <div class="home-box">
          <h2>Pagamentos</h2>
          <a href="custasJudiciais.php">Custas Judiciais</a><br>
        </div>
        <div class="home-box">
          <h2>Repasses</h2>
          <a href="repasses.php">Repasses</a><br>
        </div>
        <div class="home-box">
          <h2>Relatórios</h2>
          <a href="processos.php">Processos</a>
        </div>
      </div>
      <div class="containers">
        <div class="home-box">
        <h2>RPA</h2>
          <a href="rpa_relatorios">Relatórios</a><br>
          <a href="rpa_maquinas">Máquinas</a>
        </div>
        
        <?php 
          $query = 'SELECT * FROM Atualizacoes ORDER BY CadastradoEm DESC LIMIT 1;';
  $updates = selectData($query);
  
  function displayUpdates($updates){
    foreach ($updates as $row) {
      $updateName = htmlspecialchars($row['Titulo']);
      $description = htmlspecialchars($row['Descricao']);
      $updateDate = htmlspecialchars($row['CadastradoEm']);
      echo "<h3>" . $updateName . "</h3>";
      echo "<p>" . $description . "</p>";
      echo "<small>" . $updateDate . "</small>";
    }
  }?>
        <div class="home-box">
          <h2>Atualizações</h2>
          <?php displayUpdates($updates);?><br>
          <a href="atualizacoes.php">ver mais...</a>
        </div>
      </div>
    </div>
  </main>
  
</body>
</html>
