<?php

require_once '../includes/configSession.php';
require_once '../includes/loginView.php';
isUserLogged();

$userID = $_SESSION['user_id'];
$username = $_SESSION['user_username'];

include '../src/db_functions/select.php';

$query = "SELECT Tema FROM Usuarios WHERE UsuarioID = $userID;";
$results = selectData($query);

$tema = $results[0]['Tema'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/e21f627216.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="icon" type="image/ico" href="../public/images/favicon.ico">
  <?php echo "<link rel='stylesheet' href='../public/css/" . $tema . "_v4.css'>"; ?>
  <?php echo "<link rel='stylesheet' href='../public/css/styles_v4.css'>"; ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <title>CobImov</title>
</head>
<body>

  <a class="home-link" href="../pages/home.php">CobImov</a>

  <nav class="navbar">  
      <div class="nav-links">
        <?php echo "<div class='profile'><i class='fa-regular fa-user'></i> Ola, ". $username . "</div>" ?>
        <a class="navbar-button" href="../pages/home.php"><img class="navbar-icon" src="../public/images/icons/home.svg"></a>
        <a class="navbar-button" href="../pages/configuracoes.php"><img class="navbar-icon" src="../public/images/icons/settings.svg"></a>
        <a class="navbar-button" href="../includes/logout.php"><img class="navbar-icon" src="../public/images/icons/log-out.svg"></a>
    </div>
  </nav>

  <button class="side-bar-button"><i class="fa-solid fa-bars" style="color: #ffffff;"></i></button>

  <div class="side-bar">
    <div class="side-bar-links">
      <h3>Geral</h3>
      <a href="arquivos_remessa.php">Remessa</a><br>
      <a href="administradoras.php">Administradoras</a><br>
      <a href="condominios.php">Condomínios</a><br>
      <a href="sienge.php">Sienge</a>
      <h3>Pagamentos</h3>
      <a href="custasJudiciais.php">Custas Judiciais</a>
      <h3>Repasses</h3>
      <a href="repasses.php">Repasses</a>
      <h3>Relatórios</h3>
      <a href="processos.php">Processos</a>
      <h3>Colaborador</h3>
      <a href="colaborador_area">Pagamentos</a>
      <h3>RPA</h3>
      <a href="rpa_relatorios">Relatórios</a>
    </div>
  </div>

  <script src="../js/navbar.js"></script>