<?php include_once '../public/partials/header.php';?>

<div class="wrapper">
    <h1>Consultar Administradoras e Condomínios</h1>

    <?php
    require_once '../src/filters/administradoras.php'; 
    require_once '../src/db_functions/select.php';

    $query = "SELECT Condominios.*, Administradoras.Nome AS Administradora, CondominiosInfoAd.* FROM Condominios
              JOIN CondominiosInfoAd ON Condominios.CondID = CondominiosInfoAd.CondID
              JOIN Administradoras ON CondominiosInfoAd.AdministradoraID = Administradoras.AdministradoraID
              WHERE CondominiosInfoAd.AdministradoraID = '$administradoraID'
              ORDER BY CondName ASC;";

    $results = selectData($query);

    if (!empty($results)) {
        $administradora = $results[0]['Administradora'];
        $numeroCondominios = count($results);
    
        echo "<h2>$administradora</h2>";
    
        echo "<table class='tables'>
                <tr>
                    <th>Condomínio</th>
                    <th>Endereço</th>
                    <th>Unidades</th>
                    <th>Taxa boleto</th>
                    <th>Taxa garantidora</th>
                    <th>Dia(s) vencimento</th>
                </tr>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['CondName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['StreetName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Unidades']) . "</td>";
            echo "<td>R$ " . htmlspecialchars($row['TaxaBoletoValor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TaxaGarantidora']) . " %</td>";
            echo "<td>" . htmlspecialchars($row['DiaVencimento']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<h3>Condomínios: " . $numeroCondominios . "</h3>";
    }
    ?>
</div>

    <div class="buttons-container">
        <a href="administradoras.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>


</body>
</html>
