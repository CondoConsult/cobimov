<?php include_once '../public/partials/header.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

  <main>
    <div class="wrapper">
      <h1>Informações Bancárias > Cadastrar</h1>

        <div class="box">
          <form action="../src/db_forms/informacoes_bancarias.php" method="POST">
            <h2>Cadastrar</h2>
            
            <?php require_once '../src/selects/condominios.php'?><br>
            
            <label>Meio de pagamento</label><br>
            <select name="meio-pagamento" id="meio-pagamento" onchange="showInputs()" required>
              <option value="TED/DOC">TED/DOC</option>
              <option value="Pix">Pix</option>
            </select><br>

            <div id="ted-doc">
             <?php require_once '../src/selects/bancos.php'?><br>
             <label>Agência sem digito</label><br>
             <input type="number" name="agencia"><br>
             <label for="" id="conta-label">Número da conta</label><br>
             <input type="number" name="conta-numero" id="conta" placeholder="-">
             <input type="number" name="conta-digito" id="digito-conta" placeholder="digito"><br>
            </div>

            <div id="pix">
              <label>Tipo de chave</label><br>
              <select name="tipo-chave">
                <option value="E-mail">E-mail</option>
                <option value="Celular">Celular</option>
                <option value="CNPJ">CNPJ</option>
                <option value="Chave">Chave</option>
              </select><br>
              <label>Chave</label><br>
              <input type="text" name="chave-pix">
            </div>

            <label>Tipo de conta</label><br>
            <select name="tipo-conta" id="" required>
              <option value="Principal">Principal</option>
              <option value="Secundária">Secundária</option>
              <option value="Terceiro">Terceiro</option>
            </select><br>
            
            <label>CPF/CNPJ Terceiro</label><br>
            <input name="cpf-cnpj-terceiro" type="text"><br>

            <label>Bloquear repasse?</label><br>
            <select name="bloquear-repasse" required>
              <option value="Não">Não</option>
              <option value="Sim">Sim</option>
            </select>
          </div>

        <div class="buttons-container">
          <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
          <button name="button" value="insert" class="btn primary" type="submit">Cadastrar</button>
        </div>
      </form>
    </div>
    </main>

  <script src="../js/cadastrarInformacoesBancarias.js"></script>
  
</body>
</html>
