<?php include_once '../public/partials/header.php';?>

  <main>
    <div class="wrapper">
      <h1>Editar Informações Bancárias</h1>

      <?php

      if ($_SERVER["REQUEST_METHOD"] === "POST") {

        try {
          $infoID = $_POST['edit']; 

          require_once "../src/db_functions/select.php";
          
          $query = "SELECT * FROM InformacoesBancarias 
                    LEFT JOIN Bancos ON InformacoesBancarias.BancoID = Bancos.BancoID
                    WHERE InfoID = '$infoID';";

          $results = selectData($query);

        } catch (PDOException $error) {
          die("Query failed: " . $error->getMessage());
        }
        
        foreach ($results as $row) {
          $bancoNome = htmlspecialchars($row['BancoNome']);
          $condominioID = htmlspecialchars($row['CondID']);
          $bancoID = htmlspecialchars($row['BancoID']);
          $agencia = htmlspecialchars($row['Agencia']);
          $contaDigito = htmlspecialchars($row['ContaDigito']);
          $contaNumero = htmlspecialchars($row['ContaNumero']);
          $meioPagamento = htmlspecialchars($row['MeioPagamento']);
          $tipoConta = htmlspecialchars($row['TipoConta']);
          $bloquearRepasse = htmlspecialchars($row['BloquearRepasse']);
          $tipoChave = htmlspecialchars($row['TipoChave']);
          $chavePix = htmlspecialchars($row['Pix']);
          $cpfcnpjTerceiro = htmlspecialchars($row['CPFCNPJTerceiro']);
        }
      }

      ?>

      <div class="containers">
        <div class="box">
          <form action="../src/db_forms/informacoes_bancarias.php" method="POST">

            <input type="text" name="info-id" value="<?php echo $infoID ?>" hidden><br>
            <input type="text" name="condominio-id" value="<?php echo $condominioID ?>" hidden><br>

            <label>Pagamento</label><br>
            <select name="meio-pagamento" id="meio-pagamento" onchange="showInputs()">
              <option value="TED/DOC" <?php echo (trim($meioPagamento) === 'TED/DOC') ? 'selected' : ''; ?>>TED/DOC</option>
              <option value="Pix" <?php echo (trim($meioPagamento) === 'Pix') ? 'selected' : ''; ?>>Pix</option>
            </select><br>
                        
            <div id="ted-doc">
            <label for="">Agencia sem digito</label><br>
            <input type="number" name="agencia" value="<?php echo $agencia ?>"><br>
            <label for="">Numero da conta</label><br>
            <input type="number" name="conta-numero" id="conta" value="<?php echo $contaNumero ?>" placeholder="conta">
            <input type="number" name="conta-digito" id="digito-conta" value="<?php echo $contaDigito ?>" placeholder="digito"><br>
            </div>

            <div id="pix">
              <label>Tipo de chave</label><br>
              <select name="tipo-chave">
                <option value="E-mail" <?php echo (trim($tipoChave) === 'E-mail') ? 'selected' : ''; ?>>E-mail</option>
                <option value="Celular" <?php echo (trim($tipoChave) === 'Celular') ? 'selected' : ''; ?>>Celular</option>
                <option value="CNPJ" <?php echo (trim($tipoChave) === 'CNPJ') ? 'selected' : ''; ?>>CNPJ</option>
                <option value="Chave aleatória" <?php echo (trim($tipoChave) === 'Chave') ? 'selected' : ''; ?>>Chave aleatória</option>
              </select><br>
              <label>Chave</label><br>
              <input type="chave" name="chave-pix" value="<?php echo $chavePix ?>">
            </div>

            <label for="">Tipo de conta</label><br>

            <div class="attention-container">
            <p>Atencao! a opcao "Principal" determina a conta utilizada para programacao de repasses. <br>
             A alteracao desse campo afetara todos os repasses programados que ainda nao foram cadastrados no banco.</p>
            </div>

            <select name="tipo-conta">
              <option value="Principal" <?php echo (trim($tipoConta) === 'Principal') ? 'selected' : ''; ?>>Principal</option>
              <option value="Secundária" <?php echo (trim($tipoConta) === 'Secundária') ? 'selected' : ''; ?>>Secundária</option>
              <option value="Terceiro" <?php echo (trim($tipoConta) === 'Terceiro') ? 'selected' : ''; ?>>Terceiro</option>
            </select><br>

            <label>CPF/CNPJ Terceiro</label><br>
            <input name="cpf-cnpj-terceiro" type="text" value="<?php echo $cpfcnpjTerceiro ?>"><br>

            <label for="">Bloquear repasse?</label><br>
            <select name="bloquear-repasse" id="">
              <option value="Não" <?php echo (trim($bloquearRepasse) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($bloquearRepasse) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select>
          </div>
        </div>
        <div class="buttons-container">
          <button name="button" value="update" class="btn primary" type="submit">Salvar</button>
            <a href="consultarInformacoesBancarias.php"><button class="btn secondary" type="button">Voltar</button></a>
          <button name="button" value="delete" class="btn remove" type="submit">remover</button>
        </div>
      </form>
    </div>
  </main>

<script src="../js/cadastrarInformacoesBancarias.js"></script>
</body>
</html>
