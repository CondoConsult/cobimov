<?php include_once '../public/partials/header.php';?>

  <main>
    <div class="wrapper">
      <h1>Custas Judiciais Novo Lançamento</h1>
      <p>O que será lançado?</p>
      <ul>
        <li>Contas a pagar</li>
        <li>Contas a receber</li>
      </ul>

      <?php 
      
      include_once '../src/filters/condominios.php';
      require_once '../src/db_functions/select.php';

      if (!empty($condFiltro)) {
        
      $query = "SELECT CondName FROM Condominios WHERE CondID = '$condFiltro';";
      $results = selectData($query);

      foreach ($results as $row) {
        echo "<h2>" . htmlspecialchars($row['CondName']) . "</h2>";
      }
      
      ?>

      <form action="../src/db_forms/custas_judiciais.php" method="post">
        <div class="containers">
            <div class="box">

              <label for="responsavel">Responsável</label><br>
                <select name="responsavel">
                  <option value="Condo Consult">Condo Consult</option>
              </select><br>

              <input type="text" name="condominio" value="<?php echo $condFiltro?>" hidden>

              <?php 

              include_once '../src/selects/classes.php';

              $query = "SELECT * FROM Unidades WHERE CondID = '$condFiltro';";
              $results = selectData($query);

              echo "<br><label>Unidade</label><br>
                    <select name='unidade'>";
              foreach ($results as $row) {
                $unidade = htmlspecialchars($row['Unidade']);
                echo "<option value'" . $unidade . "'>" . $unidade . "</option>";
              }
              echo "</select><br>";
              ?>

              <label for="nome-proprietario">Nome do Proprietário</label><br>
              <input type="text" name="nome-proprietario"><br>
            
            </div>

            <div class="box">
              <label for=" ">Linha digitável</label><br>
              <input class="input-linha-digitavel" id="linha-digitavel" name="linha-digitavel" type="text" placeholder="000 0 00000 0 000000 0000 0 0000000000 0 000000000000000 0" max-length="48"required><br>
              <label for="valor">Valor</label><br>
              <input type="number" name="valor" step="0.01" min="0.00" required><br>
              <label for="data-pagamento">Data de pagamento</label><br>
              <input name="data-pagamento" type="date" required><br>
              <label for="descricao">Descrição</label><br>
              <input name="descricao" type="text" required>
            </div>

          </div>

        <div class="buttons-container">
          <button class="btn primary" name="button" value="insert" type="submit">Cadastrar</button>
        <?php } ?>
          <a href="custasJudiciais.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>
      </form>
    </div>
  </main>

  <script src="../js/inputFields.js"></script>
  
</body>
</html>
