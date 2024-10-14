<?php include_once '../public/partials/header.php';?>

        <div class="wrapper">
          <h1>Editar Administradora</h1>

        <?php
        include_once '../src/db/dbh.php';
        include_once '../src/db_functions/select.php';

        $adminFilter = $_POST['edit'];

        $query = "SELECT * FROM Administradoras WHERE AdministradoraID = '$adminFilter' ORDER BY Nome ASC";
        $results = selectData($query);

        foreach ($results as $row) {
          $administradoraID = htmlspecialchars($row['AdministradoraID']);
          $name = htmlspecialchars($row['Nome']);
          $endereco = htmlspecialchars($row['Endereco']);
          $phone = htmlspecialchars($row['Telefone']);
          $celular = htmlspecialchars($row['Celular']);
          $email = htmlspecialchars($row['Email']);
          $phoneResidents = htmlspecialchars($row['TelefoneParaMoradores']);
          $celularMoradores = htmlspecialchars($row['CelularParaMoradores']);
          $emailResidents = htmlspecialchars($row['EmailParaMoradores']);
          $observacoes = htmlspecialchars($row['Observacoes']);
        }
      
        if (empty($adminFilter)) {
          echo "<div class='select-filter'><p> 👆 Por favor, selecione a administradora.</p></div>";
        } else { ?>

      <form action="../src/db_forms/administradora_editar.php" method="post">
        <div class="containers">
          <div class="box">
              <?php echo "<h2>" . $name . "</h2>"?>
              <input name="administradoraID" type="hidden" value="<?php echo $administradoraID;?>" readonly><br>
              <label for="nome">Nome</label><br>
              <input name="nome" type="text" value="<?php echo $name;?>" required><br>
              <label for="endereco">Endereço</label><br>
              <input name="endereco" type="text" value="<?php echo $endereco;?>"><br>
              <label for="email">E-mail</label><br>
              <input name="email" type="text" value="<?php echo $email;?>" placeholder="exemplo@email.com"><br>
              <label for="telefone">Telefone</label><br>
              <input name="telefone" id="telefone" type="text" value="<?php echo $phone;?>" placeholder="41 3333 3333"><br>
              <label for="celular">Celular</label><br>
              <input name="celular" id="celular" type="text" value="<?php echo $celular;?>" placeholder="41 99999 9999"><br>
          </div>

          <div class="box">
              <h2>Para moradores</h2>
              <label for="email-moradores">E-mail</label><br>
              <input name="email-moradores" type="text" value="<?php echo $emailResidents;?>" placeholder="exemplo@email.com"><br>
              <label for="telefone-moradores">Telefone</label><br>
              <input name="telefone-moradores" id="telefone-moradores" type="text" value="<?php echo $phoneResidents;?>" placeholder="41 3333 3333"><br>

              <label for="celular-moradores">Celular</label><br>
              <input name="celular-moradores" id="celular-moradores" type="text" value="<?php echo $celularMoradores;?>" placeholder="41 99999 9999"><br>
              
              <label for="observacoes">Observações</label><br>
              <textarea id="observacoes" name="observacoes" cols="70" rows="9" placeholder="Notas ou informações adicionais para contato, como: telefone ou e-mail"><?php echo $observacoes;?></textarea>
          </div>
        </div>

        <?php } ?>

        <div class="buttons-container">
            <button name="button" value="update" type="submit" class="btn primary">Salvar</button>
            <button name="button" value="delete" type="submit" class="btn remove">Remover</button>
            <a href="consultarAdministradora.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>
      </form>
    </div>
 </body>
</html>
