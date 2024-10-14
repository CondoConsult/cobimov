<?php 
include_once '../public/partials/header.php';
require_once '../includes/cadastrarView.php';
?>

    <div class="wrapper">
        <div class="box">
        <h1>Cadastrar Usuário</h1>
            <form action="../includes/cadastrarUsuario.php" method="POST">
                <label>Usuário</label><br>
                <input type="text" name="usuario" required><br>
                <label>Senha</label><br>
                <input type="password" name="senha" required><br>
                <label>E-mail</label><br>
                <input type="email" name="email" required><br>
                <label for="permissoes">Permissoes</label><br>
                <select name="permissoes" required>
                    <option value="admin">Administrador</option>
                    <option value="colaborador">Colaborador</option>
                </select><br>
                <?php checkSignupErrors(); ?>

                <div class="buttons-container">
                    <button name="button" class="btn primary" type="submit">Cadastrar</button>
                    <a href="configuracoes.php"><button class="btn secondary" type="button">Voltar</button></a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>