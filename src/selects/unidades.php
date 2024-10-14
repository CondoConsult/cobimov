<?php 

require_once '../src/db_functions/select.php';

$query = 'SELECT * FROM Unidades;';
$results = selectData($pdo, $query);

echo '<select name="unidade">';
foreach ($results as $row) {
    $unidade = htmlspecialchars($row['Unidade']);
    echo "<option value=" . $unidade . ">" . $unidade . "</option>";  
}
echo '</select>';