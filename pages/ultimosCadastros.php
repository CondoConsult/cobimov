<?php include_once '../public/partials/header.php';?>

  <div class="wrapper">
    <h1>Últimos Cadastros</h1>
    <p>Lista de condomínios recém cadastrados.</p>

    <?php
    include '../src/db/dbh.php';

    try {

      $query = "SELECT Condominios.*, CondominiosInfoAd.CondID AS InfoAd FROM Condominios 
                LEFT JOIN CondominiosInfoAd
                ON Condominios.CondID = CondominiosInfoAd.CondID
                ORDER BY Condominios.CondID DESC;";

      $stmt = $pdo->prepare($query);
      $stmt->execute();
  
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      $pdo = null;
      $stmt = null;

    } catch (PDOException $error) {
      die("Query failed: " . $error->getMessage());
    }

    $numeroCondominios = 0;

    echo "<div class='table-container'>
            <table class='tables'>
              <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>CNPJ</th>
              <th>Info. Adicionais?</th>
            </tr>";
  
    foreach ($results as $row ) {
      
      $infoAd = $row['InfoAd'];

      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['CondID']) . "</td>";
      echo "<td>" . htmlspecialchars($row['CondName']) . "</td>";
      echo "<td>" . htmlspecialchars($row['CGC']) . "</td>";

      if (empty($infoAd)) {
        echo "<td><i class='fa-solid fa-clock'></i></td>";
      } else {
        echo "<td><img class='processes-status-icons' src='../public/images/icons/done.svg'></td>";
      }
   
      echo "</tr>";
      $numeroCondominios += 1;
    }
    echo "</table>
          </div>";
    ?>

    <p>Condomínios: <?php echo $numeroCondominios?></p>

    <div class="buttons-container">
      <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
  </div>

</body>
</html>
