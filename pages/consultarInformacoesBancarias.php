<?php include_once '../public/partials/header.php';?>

<main>
  <div class="wrapper">
    <h1>Consultar Informações Bancárias</h1>

    <?php
    require_once "../src/filters/condominios.php";
    require_once "../src/db_functions/select.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $query = "SELECT * FROM InformacoesBancarias 
                  LEFT JOIN Bancos ON InformacoesBancarias.BancoID = Bancos.BancoID
                  JOIN Condominios ON InformacoesBancarias.CondID = Condominios.CondID
                  WHERE InformacoesBancarias.CondID = '$condFiltro';";

        $results = selectData($query);

        if (empty($results)) {
          echo "Nenhuma conta encontrada para o condomínio selecionado.";
        } else {
          foreach ($results as $row) {
            $infoID = $row['InfoID'];

            echo "<div class='container'>";
            echo "<div class='container-details'>";
            ?> 
            
            <form action="editarInformacoesBancarias.php" method="POST">
              <button class="button-edit" name="edit" value="<?php echo $infoID; ?>"><img class='processes-status-icons' src='../public/images/icons/edit.svg'></button><br><br>
            </form>
            
            <?php
            
           
            echo "<h2>" . $row['CondName'] . " - " . $row['MeioPagamento'] . "</h2>";
            if ($row['MeioPagamento'] == "TED/DOC") {
              echo "<p>" . $row['BancoNome'] . "</p>";
              echo "<label>Meio de pagamento</label>";
              echo "<p>" . $row['MeioPagamento'] . "</p>";
              echo "<label>Agência</label>";
              echo "<p>" . $row['Agencia'] . "</p>";
              echo "<label>Conta</label>";
              echo "<p>" . $row['ContaNumero'] . "-" . $row['ContaDigito'] . "</p>";
              echo "<label>Tipo de conta</label>";
              echo "<p>" . $row['TipoConta'] . "</p>";
              echo "<label>Bloquear repasse?</label>";
              echo "<p>" . $row['BloquearRepasse'] . "</p>";
            } else {
              echo "<label>Meio de pagamento</label>";
              echo "<p>" . $row['MeioPagamento'] . "</p>";
              echo "<label>Chave Pix</label>";
              echo "<p>" . $row['Pix'] . "</p>";
              echo "<label>Tipo de conta</label>";
              echo "<p>" . $row['TipoConta'] . "</p>";
              if ($row['TipoConta'] == 'Terceiro') {
                echo "<label>CPF/CNPJ Terceiro</label>";
                echo "<p>" . $row['CPFCNPJTerceiro'] . "</p>";
              }
              echo "<label>Bloquear repasse?</label>";
              echo "<p>" . $row['BloquearRepasse'] . "</p>";
            }
            echo "</div>";
            echo "</div>";
          }
        }
    }
    ?>

</div>

    <div class="buttons-container">
      <a href="cadastrarInformacoesBancarias.php"><button class="btn primary" type="button">Novo</button></a>
      <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>

</main>

<script src="../js/cadastrarInformacoesBancarias.js"></script>

</body>
</html> 