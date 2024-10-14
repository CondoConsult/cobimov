<?php

require_once '../src/db_functions/select.php';

$query = "SELECT * FROM Condominios ORDER BY CondName ASC";
$results = selectData($query);

echo '<label>Condomínio</label><br>';
echo '<select name="condominio" id="selecionar-condominio">';
foreach ($results as $row) {
    echo "<option value=" . $row['CondID'] . ">" . $row['CondName'] . "</option>";
}
echo '</select>';