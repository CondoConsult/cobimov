<?php

$year = date('Y');

echo "<select name='mes-referencia' required>";
echo "<option value=''>Selecione...</option>";
for ($month = 1; $month < 13; $month++) { 
    $formattedMonth = sprintf("%02d", $month);
    echo "<option value='" . $year . "-" . $formattedMonth . "'>" . $formattedMonth . "/" . $year . "</option>";
}
echo "</select>";