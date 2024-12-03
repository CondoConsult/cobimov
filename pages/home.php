<?php include_once '../public/partials/header.php';?>
  <main>
    <div class="wrapper">
      <div class="containers">

        <?php if ($accountType === 'admin' || $accountType === 'colaborador') {?>
          <div class="home-box">
            <h2>Geral</h2>
            <a href="arquivos_remessa">Remessa</a><br>
            <a href="administradoras">Administradoras</a><br>
            <a href="condominios">Condomínios</a><br>
            <!-- <a href="sienge">Sienge</a><br> -->
          </div>
        <?php } ?>

        <div class="home-box">
          <h2>Pagamentos</h2>
          <a href="custasJudiciais">Custas Judiciais</a><br>
        </div>

        <?php if ($accountType === 'admin') {?>
          <div class="home-box">  
            <h2>Repasses</h2>
            <a href="repasses">Repasses</a><br>
          </div>
        
        <?php } 
        if ($accountType === 'admin' || $accountType === 'colaborador') { ?>

          <div class="home-box">
            <h2>Relatórios</h2>
            <a href="processos">Processos</a>
          </div>

        <?php } ?>
      </div>

      <?php if ($accountType === 'admin' || $accountType === 'colaborador') {?>
      <div class="containers">
        <div class="home-box">
        <h2>RPA</h2>
          <a href="rpa_relatorios">Relatórios</a><br>
          <a href="rpa_maquinas">Máquinas</a><br>
          <a href="rpa_avisos_whatsapp">Avisos WhatsApp</a>
        </div>
      <?php } ?>

      <?php if ($accountType === 'APS') {?>
      <div class="containers">
        <div class="home-box">
        <h2>RPA</h2>
          <a href="rpa_relatorios">Relatórios</a><br>
        </div>
      <?php } ?>

        <div class="home-box">
          <h2>Colaborador</h2>
          <a href="colaborador_area">Pagamentos</a>
        </div>
        
        <?php 
          $query = 'SELECT * FROM Atualizacoes ORDER BY CadastradoEm DESC LIMIT 1;';
  $updates = selectData($query);
  
  function displayUpdates($updates){
    foreach ($updates as $row) {
      $updateName = htmlspecialchars($row['Titulo']);
      $description = htmlspecialchars($row['Descricao']);
      $updateDate = $dataSolicitacao = date('d/m/Y', strtotime(htmlspecialchars($row['CadastradoEm'])));
      echo "<h3>" . $updateName . "</h3>";
      echo "<p>" . $description . "</p>";
      echo "<small>" . $updateDate . "</small>";
    }
  }?>
        <div class="home-box">
          <h2>Atualizações</h2>
          <?php displayUpdates($updates);?><br>
          <a href="atualizacoes">ver mais...</a>
        </div>
      </div>
    </div>
  </main>
  
</body>
</html>
