<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Solicitar Pagamento</h1>

    <form action="../src/db_forms/colaborador_pagamentos.php" method="POST">

      <input type="text" value='<?php echo $username?>' name="solicitante" hidden>
      <label for="pix">Chave Pix</label><br>
      <input type="text" name="chave-pix" required><br>

      <label for="valor">Valor</label><br>
      <input type="number" name="valor" min="0" step="0.01" placeholder="0.00" required><br>

     <?php 

     $query = "SELECT * FROM ClassesContas WHERE CodigoClasse BETWEEN '92.01' AND '92.99' ORDER BY CodigoClasse ASC";
     $results = selectData($query);
     
     echo '<label>Classe</label><br> 
           <select name="classe" required>';  
     foreach ($results as $row) {
        $classe = $row['CodigoClasse'] . " " . $row['NomeClasse'];
        echo "<option value='" . $classe . "'>" . $classe . "</option>"; 
     }
     echo '</select>'
     ?>

      <div class="buttons-container">
        <button class="btn primary" name="button" value="insert">Solicitar</button>
        <a class="btn secondary" href="colaborador_area">Voltar</a>
      </div>

    </form>
  </div>

</body>
</html>
