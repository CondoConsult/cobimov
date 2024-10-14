<?php

require_once '../src/db_functions/select.php';

$query = "SELECT * FROM Bancos ORDER BY BancoID ASC";
$results = selectData($query);

echo '<label>Banco</label><br>  
      <select name="banco">'; 
foreach ($results as $row) {
    echo "<option value=" . $row['BancoID'] . ">" . $row['BancoID'] . " - " . $row['BancoNome'] . "</option>";
}
echo '</select>';
