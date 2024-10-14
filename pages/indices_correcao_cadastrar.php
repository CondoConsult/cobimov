<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Cadastrar Índices de Correção</h1>

        <form action="../src/db_forms/indices_correcao.php" method="POST">
        <div class="containers">
            <div class="box">
              <?php include_once '../src/selects/condominios.php'?><br>

                <label for="">Índice Convenção</label><br>
                <input name="indice-convencao" type="text" required><br>

                <label for="">Índice Contrato</label><br>
                <input name="indice-contrato" type="text" required><br>

                <label for="">Índice Cond21</label><br>
                <input name="indice-cond21" type="text" required><br>

                <label for="">Alterado para</label><br>
                <input name="alterado-para" type="text" required>
            </div>
        </div>
          <div class="buttons-container">
             <button name="button" value="insert" class="btn primary" type="submit">Cadastrar</button>
             <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
          </form>
        </div>

  </div>

</body>
</html>