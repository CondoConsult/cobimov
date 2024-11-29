<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Programar Novo Repasse</h1>

    <?php
      require_once "../src/filters/condominios.php";
  
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        require_once "../src/db_functions/select.php";

        try {
          $query = "SELECT * FROM InformacoesBancarias
                    LEFT JOIN Bancos ON InformacoesBancarias.BancoID = Bancos.BancoID    
                    JOIN Condominios ON InformacoesBancarias.CondID = Condominios.CondID    
                    WHERE InformacoesBancarias.CondID = '$condFiltro' AND TipoConta = 'Principal';";

          $results = selectData($query);

          echo "<div class='form-box'>";
          foreach ($results as $row) {
            $contaID = htmlspecialchars($row["InfoID"]);
            $condID = htmlspecialchars($row["CondID"]);
            $pix = htmlspecialchars($row["Pix"]);
            $bloquearRepasse = htmlspecialchars($row["BloquearRepasse"]);
            echo "<h2>" .  htmlspecialchars($row["CondName"]) . "</h2>";
            if ($row['MeioPagamento'] == 'TED/DOC') {
              echo "<label>Banco</label><p>" .  htmlspecialchars($row["BancoID"]) . " - " . htmlspecialchars($row["BancoNome"]) . "</p>";
              echo "<label>Agência</label><p>" . htmlspecialchars($row["Agencia"]) . "</p>";
              echo "<label>Conta</label><p>" . htmlspecialchars($row["ContaNumero"]) . "-". $row["ContaDigito"] . "</p>";
            } else {
              echo "<label>Chave Pix</label><p>" . $pix . "</p>";
            }
          }
          echo "</div>";

        } catch (PDOException $error) {
          die("Query failed: " . $error->getMessage());
        }

        if (empty($bloquearRepasse)) {
          $bloquearRepasse = '';
        }

        if (!empty($results) & $bloquearRepasse<>'Sim') {
    ?>

    <div class="containers">
      <div class="form-box">
        <form action="../src/db_forms/repasse.php" method="post">
          <input name="conta-id" type="number" value="<?php echo $contaID ?>" hidden>
          <input name="cond-id" type="number" value="<?php echo $condID ?>" hidden>
          <label>Valor</label><br>
          <input name="valor" type="number" step="0.01" min="0.00" required><br>
          <label>Data de pagamento</label><br>
          <input name="data-pagamento" type="date" required><br>
          <label>Categoria</label><br>
          <select name="categoria" required>
            <option value="Primeiro">Primeiro</option>
            <option value="Segundo">Segundo</option>
            <option value="Terceiro">Terceiro</option>
            <option value="Antecipação">Antecipação</option>
            <option value="Retroativos">Retroativos</option>
            <option value="Click Consult">Click Consult</option>
          </select>

          </div>
          </div>

          <div class="attention-container">
            <p>Atenção! Repasses só podem ser cadastrados em contas principais.</p>
          </div>

          </div>
          <div class="buttons-container">
            <button class="btn primary" type="submit" name="button" value="insert">Cadastrar</button>
            <a href="repasses.php"><button class="btn secondary" type="button">Voltar</button></a>
          </div>
        </form>





  <?php
      } elseif ($bloquearRepasse == 'Sim') {
         echo "Não foi possível prosseguir. Repasse bloqueado.<br>";
         echo "<a href='selecionarInformacoesBancarias.php'>Editar Informações Bancárias</a>";
         echo "<div class='buttons-container'>
               <a class='btn secondary' href='repasses.php'>Voltar</a>
               </div>";
      } elseif (empty($results)) {
         echo "Não foi possível prosseguir. Conta principal não encontrada.<br>";
         echo "<a href='consultarInformacoesBancarias.php'>Editar Informações Bancárias</a>";
         echo "<div class='buttons-container'>
               <a class='btn secondary' href='repasses.php'>Voltar</a>
               </div>";
      }
  }
  ?>
</body>
</html>
