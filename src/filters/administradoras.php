<?php

include_once "../src/db_functions/select.php";

$query = 'SELECT * FROM Administradoras ORDER BY Nome ASC;';
$results = selectData($query); ;

echo '<form method="POST" id="filtrar">
      <label>Administradora</label><br>
      <select name="filtrar-administradora" onchange="filtrar()"> 
      <option selected value="" selected>Selecionar...</option>';   
foreach ($results as $row) {
    $ID = htmlspecialchars($row['AdministradoraID']);
    $administradora = htmlspecialchars($row['Nome']);
    echo "<option value=" . $ID . ">" . $administradora . "</option>";  
}
echo '</select></form>';

if (isset($_POST['filtrar-administradora'])) {
    $administradoraID = $_POST['filtrar-administradora'];
} else {
    echo "<div class='select-filter'><p> 👆 Por favor, selecione uma opcao.</p></div>";
}

?>
<script src="../js/main.js"></script>