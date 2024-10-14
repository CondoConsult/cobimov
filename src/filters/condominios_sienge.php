<?php

include_once "../src/db_functions/select.php";

$query = "SELECT * FROM Condominios
          JOIN Grupos ON Condominios.CondID = Grupos.CondID
          WHERE Grupo = 'NOVA CASA'
          ORDER BY CondName ASC;";
    $results = selectData($query);

    echo "<form method='post' id='filtrar'>
        <label>Condomínio</label><br>
        <select name='filtrar-condominio' onchange='filtrar()'>
        <option value='' selected>Selecione...</option>";
    foreach ($results as $row) {
        echo "<option value=" . $row['CondID'] . ">" . $row['CondName'] . "</option>";  
    }

    echo "</select>
        </form>";

    if (isset($_POST['filtrar-condominio'])) {
        $condFiltro = $_POST['filtrar-condominio'];
    } else {
        echo "<div class='select-filter'><p> 👆 Por favor, selecione uma opcao.</p></div>";
    }
?>

<script src="../js/main.js"></script>
