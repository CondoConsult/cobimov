<?php include_once '../public/partials/header.php';?>

<div class="wrapper">
    <h1>Consultar Administradoras</h1>

    <?php
    require_once '../src/filters/administradoras.php'; 
    require_once '../src/db_functions/select.php';

    $query = "SELECT * FROM Administradoras WHERE AdministradoraID = '$administradoraID' ORDER BY Nome ASC";
    $results = selectData($query);

    foreach ($results as $row) {

        if (!empty($administradoraID)) {
            echo "<div class='container'>";
            echo "<div class='container-details'>";
            
        ?>
            <form action="editarAdministradora.php" method="POST">
                <button class="button-edit" name="edit" value="<?php echo $administradoraID; ?>"><img class='processes-status-icons' src='../public/images/icons/edit.svg'></button><br><br>
            </form>
        <?php }

        echo "<h2>" . htmlspecialchars($row['Nome']) . "</h2>";

        echo "<h2>Administradora</h2>";
        echo "<label>Endereço</label>";
        echo "<p>" . htmlspecialchars($row['Endereco']) . "</p>";
        echo "<label>Telefone</label>";
        echo "<p>" . htmlspecialchars($row['Telefone']) . "</p>";
        echo "<label>Celular</label>";
        echo "<p>" . htmlspecialchars($row['Celular']) . "</p>";
        echo "<label>E-mail</label>";
        echo "<p>" . htmlspecialchars($row['Email']) . "</p>";

        echo "<h2>Para moradores</h2>";
        echo "<label>Telefone</label>";
        echo "<p>" . htmlspecialchars($row['TelefoneParaMoradores']) . "</p>"; 
        echo "<label>Celular</label>";
        echo "<p>" . htmlspecialchars($row['CelularParaMoradores']) . "</p>";
        echo "<label>E-mail</label>";
        echo "<p>" . htmlspecialchars($row['EmailParaMoradores']) . "</p>";

        echo "<h2>Observações</h2>";
        echo "<p>" . htmlspecialchars($row['Observacoes']) . "</p>";
        echo "</div>";
        echo "</div>";
    }
    ?>

    <div class="buttons-container">
        <a href="administradoras.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>
</div>

</body>
</html>
