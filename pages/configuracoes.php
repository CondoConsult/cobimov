<?php include_once '../public/partials/header.php';?>

    <div class="wrapper">
      <h1>Configurações</h1>

      <?php 
        try {
          include '../src/db/dbh.php';

          $username = $_SESSION['user_username'];

          $query = 'SELECT * FROM Usuarios WHERE Usuario = :username;';
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':username', $username);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
          foreach ($results as $row) {
            $accountType =  $row['Permissoes'];
          }
    
        } catch (PDOException $error) {
          die("Query failed" . $error->getMessage());
        }

        if ($accountType <> 'admin') {?>

      <h3>Preferências</h3>
        <div class="containers">
          <a class= "menu-box" href="configuracoes_tema.php"><i class="fa-solid fa-paintbrush"></i> Tema</a>
        </div>

      <?php  } else { ?>

      <h1>Olá, <?php echo $_SESSION['user_username'];?></h1>

      <h3>Preferências</h3>
      <div class="containers">
          <a class= "menu-box" href="configuracoes_tema.php"><i class="fa-solid fa-paintbrush"></i> Tema</a>
      </div>

      <h3>Usuários</h3>
      <div class="containers">
        <a class= "menu-box" href="usuarios_cadastrar.php"><i class="fa-solid fa-plus"></i> Cadastrar</a>
        <a class="menu-box" href="usuarios.php"><i class="fa-solid fa-pen-to-square"></i> Gerenciar</a>
        <a class="menu-box" target="blank_()" href="user_access_levels.html">Niveis de Acesso</a>
      </div>
      <p>Apenas usuarios com perfil administrador tem acesso ao gerenciamento de usuarios.</p>

      <?php } ?>
    </div>

  </body>
</html>
