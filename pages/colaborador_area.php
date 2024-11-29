<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Colaboradores Pagamentos</h1>

    <h3>Pagamentos</h3>
    <div class="containers">
      <a class="menu-box" href="colaborador_solicitar_pagamento"><i class="fa-solid fa-plus"></i>Solicitar Pagamento</a>
      <a class="menu-box" href="colaborador_pagamentos"><i class="fa-solid fa-magnifying-glass"></i>Pagamentos</a>

      <?php
        if ($accountType === 'admin') { ?>
          <a class="menu-box" href="cadastro_fornecedores"><i class="fa-regular fa-building"></i> Cadastro Fornecedores</a>
      <?php } ?>

    </div>

  </div>

    <div class="buttons-container">
      <a class="btn secondary" href="home"><button>Voltar</button></a>
    </div>

</body>
</html>
