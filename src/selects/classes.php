<?php

require_once '../src/db_functions/select.php';

$query = "SELECT * FROM ClassesContas WHERE CodigoClasse BETWEEN '07.01' AND '07.37' ORDER BY CodigoClasse ASC";
$results = selectData($query);

echo '<label>Classe</label><br> 
      <select name="classe" required>';  
foreach ($results as $row) {
    echo "<option value=" . $row['CodigoClasse'] . ">" . $row['CodigoClasse'] . " ". $row['NomeClasse'] . "</option>"; 
}
echo '</select>';