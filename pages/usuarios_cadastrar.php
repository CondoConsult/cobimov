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
                <label for="permissoes">Permissões</label><br>
                <select name="permissoes" required>
                    <option value="admin">Administrador</option>
                    <option value="colaborador">Colaborador</option>
                    <option value="APS">APS</option>
                </select><br>

                <a target="_blank()" href="user_access_levels">Verificar as permissões de acesso <i class="fa-solid fa-square-arrow-up-right"></i></a>
                <?php checkSignupErrors(); ?>
    
        </div>
    </div>

                <div class="buttons-container">
                    <button name="button" class="btn primary" type="submit">Cadastrar</button>
                    <a href="configuracoes"><button class="btn secondary" type="button">Voltar</button></a>
                </div>
            </form>

</body>
</html>