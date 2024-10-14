<?php include_once '../public/partials/header.php';?>

  <main>
    <div class="wrapper">
      <h1>Cadastrar Administradora</h1>

      <form action="../src/db_forms/administradora_cadastrar.php" method="post">
        <div class="containers">
          <div class="box">
            <h2>Administradora</h2> 
            <label for="nome">Nome</label><br>
            <input name="nome" type="text" required><br>
            <label for="endereco">Endereço</label><br>
            <input name="endereco" type="text"><br>

            <label for="email-administradora">E-mail</label><br>
            <input name="email-administradora[]" type="email">
            <button class="button-plus" type="button" onclick="adicionarCampo('email-administradora[]', 'adicionar-email-administradora')">+</button><br>
            <div id="adicionar-email-administradora"></div>

            <label for="telefone-administradora">Telefone</label><br>
            <input id="telefone-administradora" name="telefone-administradora[]" type="text" placeholder="41 3333 3333">
            <button class="button-plus" type="button" onclick="adicionarCampo('telefone-administradora[]', 'adicionar-telefone-administradora')">+</button><br>
            <div id="adicionar-telefone-administradora"></div>

            <label for="celular-administradora">Celular</label><br>
            <input id="celular-administradora" name="celular-administradora[]" type="text" placeholder="41 99999 9999">
            <button class="button-plus" type="button" onclick="adicionarCampo('celular-administradora[]', 'adicionar-celular-administradora')">+</button><br>
            <div id="adicionar-celular-administradora"></div>

          </div>
          <div class="box">
            <h2>Para moradores</h2>
            <label for="email-moradores">E-mail</label><br>
            <input name="email-moradores[]" type="email">          
            <button class="button-plus" type="button" onclick="adicionarCampo('email-moradores[]', 'adicionar-email-moradores')">+</button><br>
            <div id="adicionar-email-moradores"></div>

            <label for="telefone-moradores">Telefone</label><br>
            <input id="telefone-moradores" name="telefone-moradores[]" type="text" placeholder="41 3333 3333">            
            <button class="button-plus" type="button" onclick="adicionarCampo('telefone-moradores[]', 'adicionar-telefone')">+</button><br>
            <div id="adicionar-telefone"></div>

            <label for="celular-moradores">Celular</label><br>
            <input id="celular-moradores" name="celular-moradores[]" type="text" placeholder="41 99999 9999">
            <button class="button-plus" type="button" onclick="adicionarCampo('celular-moradores[]', 'adicionar-celular-moradores')">+</button><br>
            <div id="adicionar-celular-moradores"></div>

            <label for="observacoes">Observações</label><br>
            <textarea name="observacoes" cols="70" rows="8" placeholder="Notas ou informações adicionais."></textarea>
          </div>
        </div>

        <div class="buttons-container">
          <button class="btn primary" type="submit">Cadastrar</button>
          <button class="btn remove" type="reset">Limpar</button>
          <a href="administradoras.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>
      </form>
    </div>
  </main>
  <script src="../js/camposAdicionais.js"></script>
  <script src="../js/cadastrarAdministradora.js"></script>

</body>
</html>
