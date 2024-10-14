<?php
require_once 'includes/configSession.php';
require_once 'includes/loginView.php';

if (isset($_GET['login']) && $_GET['login'] === "success") {
  header("Location: pages/home.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/light_v2.css">
    <link rel='stylesheet' href='public/css/styles_v2.css'>
    <link rel="icon" type="image/ico" href="public/images/favicon.ico">
    <script src="https://kit.fontawesome.com/e21f627216.js" crossorigin="anonymous"></script>
    <title>CobImov Acessar</title>
</head>
<body>

    <main>
        <div class="login-background">
            <img class="login-logo" src="public/images/logo_white.png" alt="Condo Consult">
        <div class="login-container">
            <h1 class="login-heading">CobImov</h1>

            <div class="login-fields">
              <form action="includes/login.php" method="POST">
                <input class="username" name="usuario" type="text" placeholder="Usuário" required> <br>
                <input class="password" name="senha" type="password" placeholder="Senha" required> <br>
                <button class="login-button" type="submit">Acessar</button>
              </form>

              <?php
                $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                if (strpos($fullUrl, "error=incorrect") == true) {
                  echo "<div class='login-error'>Credenciais incorretas. Tente novamente.</div>";
                }
              ?>
            </div>
        </div>
      </div>
    </main>

</body>
</html>