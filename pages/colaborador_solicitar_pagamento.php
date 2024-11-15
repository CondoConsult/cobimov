<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Solicitar Pagamento</h1>

    <form action="../src/db_forms/colaborador_pagamentos.php" method="POST">

      <input type="text" value='<?php echo $username?>' name="solicitante" hidden>

      <label>Forma de pagamento</label><br>
      <select name="metodo-pagamento" id="metodo-pagamento">
        <option value="Boleto">Boleto</option>
        <option value="Pix">Pix</option>
      </select><br>

      <label>Tipo de chave</label><br>
      <select name="tipo-chave">
        <option value="CPF/CNPJ">CPF/CNPJ</option>
        <option value="Celular">Celular</option>
        <option value="E-mail">E-mail</option>
        <option value="Chave">Chave</option>
      </select><br>

      <label for="pix" id="metodo-pagamento-label">Boleto</label><br>
      <input type="text" name="chave-pix-boleto" required><br>

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
     echo '</select><br>'
     ?>

     <label>Anexar documento</label><br>
     <input type="file" name=''>

      <div class="buttons-container">
        <button class="btn primary" name="button" value="insert">Solicitar</button>
        <a class="btn secondary" href="colaborador_area">Voltar</a>
      </div>

    </form>
  </div>


<script>

  const paymentMethodSelect = document.getElementById("metodo-pagamento");
  const paymentLabel = document.getElementById("metodo-pagamento-label");

  function updateLabel() {
    const selectedMethod = paymentMethodSelect.value;
    if (selectedMethod === "Pix") {
      paymentLabel.textContent = "Chave Pix";
    } else {
      paymentLabel.textContent = "Boleto"; 
    }
  }

  updateLabel();
  paymentMethodSelect.addEventListener("change", updateLabel);
</script>

</body>
</html>
