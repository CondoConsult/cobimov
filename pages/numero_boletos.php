<?php include_once '../public/partials/header.php';?>

    <div class="wrapper">
        <h1>Número de Boletos</h1>

        <form method="POST">
            <label>Mês de Referência</label><br>
            <select name="mes-referencia">
                <option value="03/2024">03/2024</option>
                <option value="04/2024">04/2024</option>
                <option value="05/2024">05/2024</option>
                <option value="06/2024">06/2024</option>
                <option value="07/2024">07/2024</option>
                <option value="08/2024">08/2024</option>
                <option value="09/2024">09/2024</option>
                <option value="10/2024">10/2024</option>
                <option value="11/2024">11/2024</option>
                <option value="12/2024">12/2024</option>
            </select>
            <button class="btn filter">Filtrar</button>
        </form>

        <?php

        $mesReferencia = $_POST['mes-referencia'];

        if (!isset($mesReferencia)) {
            $currentDay = date('d');
            $mesReferencia = date('m/Y');
            if ($currentDay > 20) {
                $date = DateTime::createFromFormat('m/Y', $mesReferencia);
                $date->modify('+1 month');
                $mesReferencia = $date->format('m/Y');
            }
        }

        echo '<h2>' . $mesReferencia . '</h2>';

        require_once '../src/db_functions/select.php';

        $query = "SELECT UnidadesRemessa.*, Condominios.CondName, Condominios.CondID 
                  FROM Condominios 
                  LEFT JOIN UnidadesRemessa ON Condominios.CondID = UnidadesRemessa.CondID 
                  AND UnidadesRemessa.MesReferencia = '$mesReferencia'
                  ORDER BY Condominios.CondName ASC;";
        $unidadesRemessa = selectData($query);

        echo "<form action='numero_boletos_editar.php' method='POST'>
              <input name='mes-referencia' value='" . $mesReferencia . "'hidden> 
              <div class='table-container'>
                <table class='tables'>
                    <tr>
                        <th>Condominio</th>
                        <th>Boletos Extras</th>
                        <th>Boletos Unicos</th>
                        <th>Unidades Boletos Unicos</th>
                        <th></th>
                    </tr>";
        foreach ($unidadesRemessa as $row) {
            $condominio = htmlspecialchars($row['CondName']);
            $condominioID = htmlspecialchars($row['CondID']);
            $boletosExtras = htmlspecialchars($row['BoletosExtras']);
            $boletosUnicos = htmlspecialchars($row['BoletosUnicos']);
            $unidadesBoletosUnicos = htmlspecialchars($row['UnidadesBoletosUnicos']);

            echo "<tr>
                    <td>" . $condominio . "</td>
                    <td>" . $boletosExtras . "</td>
                    <td>" . $boletosUnicos . "</td>
                    <td>" . $unidadesBoletosUnicos . "</td>
                    <td><button name='condominio-id' value='" . $condominioID ."'><img class='processes-status-icons' src='../public/images/icons/edit.svg'></button></td>
                  <tr>";
        }
        echo "</div>
              </table>
              </form>";
        ?>

    </div>

    <div class="buttons-container">
        <a href="arquivos_remessa.php"><button class="btn secondary" type="button">Voltar</button></a>  
    </div>
</body>
</html>