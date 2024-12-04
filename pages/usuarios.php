<?php include_once '../public/partials/header.php'; ?>

<div class="wrapper">
    <h1>Gerenciar Usuários</h1>
        
    <?php
    include_once '../src/db_functions/select.php';

    $query = "SELECT * FROM Usuarios ORDER BY Usuario ASC;";
    $results = selectData($query);

    foreach ($results as $row) {
      echo "<form action='../src/db_forms/usuarios.php' method='POST'>";
      echo "<input type='hidden' name='user-id' value='" .  $row['UsuarioID'] . "'>";
      echo "<p><button value='delete' class='btn remove' name='button'>Remover</button> " . $row['Usuario'] . " - " . $row['Permissoes'] . "</p>";
      echo "</form>";
    }
    ?>

</div>
</div>
        <div class="buttons-container">
            <a href="configuracoes.php"><button class="btn secondary" type="button">Voltar</button></a>
        </div>

</body>