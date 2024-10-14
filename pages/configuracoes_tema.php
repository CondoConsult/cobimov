<?php
require_once '../includes/configSession.php';
require_once '../includes/loginView.php';
isUserLogged();

$userID = $_SESSION['user_id'];
?>

<?php include_once '../public/partials/header.php';?>

    <div class="wrapper">
      <h1>Tema</h1>

      <form action="../src/db_forms/configuracoes.php" method="POST">
        <input type="text" name="usuario-id" value="<?php echo $userID ?>" hidden>
        <select name="tema">
          <option value="light">Claro</option>
          <option value="dark">Escuro</option>
        </select>
        <button class="btn primary" type="submit">Alterar</button>
      </form>
    </div>

  </body>
</html>
