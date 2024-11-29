<?php include_once '../public/partials/header.php';?>

    <div class="wrapper">
      <h1>RPA</h1>
        <h3>Relatórios</h3>
        <div class="containers">
          <a class="menu-box" href="rpa_historico_execucoes"><i class="fa-solid fa-clock-rotate-left"></i> Histórico de execuções</a>
          <?php if ($accountType === 'admin') { ?>
            <a class="menu-box" href="rpa_tempo_economizado"><i class="fa-solid fa-chart-simple"></i> Tempo economizado</a>
          <?php } ?>
        </div>
    </div> 

        <div class="buttons-container">
         <a href="home.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>
        
  </body>
</html>
