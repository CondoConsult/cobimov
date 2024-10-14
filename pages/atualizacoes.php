<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';

$query = 'SELECT * FROM Atualizacoes ORDER BY CadastradoEm DESC;';
$updates = selectData($query);

function displayUpdates($updates) {
    foreach ($updates as $row) {
        $updateName = htmlspecialchars($row['Titulo']);
        $description = htmlspecialchars($row['Descricao']);
        $updateDate = htmlspecialchars($row['CadastradoEm']);
        echo "<h2>" . $updateName . "</h2>";
        echo "<p>" . $description . "</p>";
        echo "<small>" . $updateDate . "</small><hr>";
    }
}
?>

<div class="wrapper">
    <h1>Atualizações</h1>

    <div class="containers">
        <div class="home-box">
            <?php displayUpdates($updates); ?>
        </div>
    </div>

    <div class="buttons-container">
        <a href="home.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
</div>

</body>
</html>
