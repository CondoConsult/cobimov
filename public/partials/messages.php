<style>
    body {
        background-color: #1a1a1a;
        color: #cfcfcf;
    }

    .message-container {
        background-color: #292929;
        padding: 30px;
        border-radius: 20px;
        width: 300px;
        line-height: 2rem;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    a {
        color: #941F25; 
        text-decoration: none;
    }
</style>


<?php 

function selecioneCondominio() {
    echo "<div class='select-filter'><p> 👆 Por favor, selecione o condominio.</p></div>";
}

function cadastroEfetuado($page) {
    echo "<div class='message-container'>
            Cadastro efetuado com sucesso.<br>
            <a href='../../pages/" . $page . ".php'>OK</a>
          </div>";
}

function cadastroAtualizado($page) {
    echo "<div class='message-container'>
            Cadastro atualizado com sucesso.<br>
            <a href='../../pages/" . $page . ".php'>OK</a>
         </div>";
}

function cadastroRemovido($page) {
    echo "<div class='message-container'>
            Cadastro removido com sucesso.<br>
            <a href='../../pages/" . $page . ".php'>OK</a>
        </div>";
}