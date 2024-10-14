<?php
include_once "../src/db_functions/select.php";

$query = "SELECT * FROM Condominios ORDER BY CondName ASC;";
$results = selectData($query);

echo "<form method='post'>";
echo '<label>Condomínios</label><br>';
echo '<select class="multiple-select" name="condominios[]" multiple>'; 
foreach ($results as $row) {
    echo "<option value=" . $row['CondID'] . ">" . $row['CondName'] . "</option>";  
}
echo "</select><br>";

echo "<div class='buttons-container'>
      <button class='button-left' type='submit'>Selecionar</button>
      </div>";
echo "</form>";

if (isset($_POST['condominios'])) {
    $condFiltro = $_POST['condominios'];
} else {
    $condFiltro = '';
}

