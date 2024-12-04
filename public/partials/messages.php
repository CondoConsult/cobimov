<style>

    @import url('https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;800&display=swap');

    .message-container {
        padding: 30px;
        border-radius: 20px;
        width: 300px;
        line-height: 2rem;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        font-family: 'Maven Pro', sans-serif;
        background-color: #f4f4f4;
    }

    a {
        color: #fff; 
        text-decoration: none;
        background-color: #941F25;
        padding: 10px;
        border-radius: 10px;
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