<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">

    <?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            require_once "../src/db_functions/select.php";

            $custaID = $_POST["custa-id"];

            $query = "SELECT * FROM LancamentosCJudiciais WHERE CustaID = '$custaID';";
            $results = selectData($query);

            foreach ($results as $row) {
              $unidade = htmlspecialchars($row["Unidade"]);
              $classe = htmlspecialchars($row["Classe"]);
              $valor = htmlspecialchars($row["Valor"]);
              $dataPagamento = htmlspecialchars($row["DataPagamento"]);
              $linhaDigitavel = htmlspecialchars($row["LinhaDigitavel"]);
              $responsavel = htmlspecialchars($row["Responsavel"]);
              $nomeProprietario = htmlspecialchars($row["NomeProprietario"]);
              $descricao = htmlspecialchars($row["Descricao"]);
            }

        } catch (PDOException $error) {
            die("Query failed" . $error->getMessage());
        }
    } else {
        header("Location: home.php");
        exit;
    }
    ?>

    <form action="../src/db_forms/custas_judiciais.php" method="post">
       <div class="containers">
         <div class="box">

           <input type="text" name="custa-id" value="<?php echo $custaID ?>" hidden> <br>
           
           <label for="unidade">Unidade</label><br>
           <input name="unidade" type="text" value="<?php echo $unidade ?>" required><br>

           <label for="nome-proprietario">Nome do Proprietário</label><br>
           <input type="text" name="nome-proprietario" value="<?php echo $nomeProprietario ?>"><br>

           <label>Linha digitável</label><br>
           <input class="input-linha-digitavel" id="linha-digitavel" name="linha-digitavel" value="<?php echo $linhaDigitavel ?>" type="text" placeholder="000 0 00000 0 000000 0000 0 0000000000 0 000000000000000" max-length="47"required><br>
           
           <label for="valor">Valor</label><br>
           <input type="number" name="valor" step="0.01" min="0.00" value="<?php echo $valor ?>" required><br>
           
           <label for="data-pagamento">Data de pagamento</label><br>
           <input name="data-pagamento" type="date" value="<?php echo $dataPagamento ?>" required><br>

           <label for="responsavel">Responsável</label><br>
           <select name="responsavel">
             <option value="Condo Consult">Condo Consult</option>
            <!-- <option value="Azevedo, Paste e Surkamp">Azevedo, Paste e Surkamp</option> -->
           </select><br>

           <label for="descricao">Descrição</label><br>
           <input name="descricao" type="text" value="<?php echo $descricao ?>" required>

         </div>
       </div>
       <div class="buttons-container">
         <button name="button" value="update" class="btn primary"  type="submit">Salvar</button>
         <button name="button" value="delete" class="btn remove" type="submit">Remover</button>
         <a href="consultarCustasJudiciais.php"><button class="btn secondary" type="button">Voltar</button></a>
       </div>
     </form>
  </div>

  <script src="../js/inputFields.js"></script>

</body>
</html>


