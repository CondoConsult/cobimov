<?php 
  include_once '../public/partials/header.php';
  include_once '../src/db_functions/select.php';
?>

  <div class="wrapper">
    <h1>Bloquear Envios Avisos WhatsApp</h1>
    <p>Informe o numero ou cliente que deseja remover da lista de envio de mensagens.</p>

    <form action="../src/db_forms/avisos_whatsapp.php" method="POST">
      <label>Telefone</label>
      <input type="phone" name="numero-telefone" placeholder="41999999999"><br>
      <label>Nome Contato</label>
      <input type="text" name="nome-contato"><br>
      <button class="btn primary" name="button" value="insert">Adicionar</button>
    </form>

    <p>Nao enviar para:</p>

    <?php 
    
      $query = "SELECT * FROM rpa_avisos_whatsapp;";
      $result = selectData($query);

        foreach ($result as $row) {
          $telefone = $row['telefone'];
          $nomeContato = $row['nome_contato'];

          
          ?>       
          
          <form action="../src/db_forms/avisos_whatsapp.php" method="POST">
            <input value="<?php echo $telefone?>" name='numero-telefone' hidden>
            <?php echo $telefone . " - " . $nomeContato;?>
            <button class='btn' name='button' value='delete'><img class='processes-status-icons' src='../public/images/icons/trash.svg'></button><br>
          </form>
      <?php } ?>

      </form>

    <div class="buttons-container">
      <a href="rpa_avisos_whatsapp.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>

  </div>
</body>
</html>