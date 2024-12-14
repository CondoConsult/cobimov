<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $email = $_POST["email"];
    $permissoes = $_POST["permissoes"];

    try {

        require_once '../src/db/dbh.php';
        require_once 'cadastrarModel.php';
        require_once 'cadastrarContr.php';

        $errors = [];

        if (isInputEmpty($usuario, $senha, $email)) {
            $errors["empty_input"] = "Por favor, preencha todos os campos.";
        }
        if (isEmailInvalid($email)) {
            $errors["invalid_email"] = "E-mail invalido.";
        }
        if (isUsernameTaken($pdo, $usuario)) {
            $errors["username_taken"] = "Usuario ja existente.";
        }
        if (isEmailRegistered($pdo, $email)) {
            $errors["email_used"] = "E-mail ja cadastrado.";
        }

        require_once 'configSession.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            header("Location: ../pages/usuarios_cadastrar.php");
            die();
        }

        createUser($pdo, $senha, $usuario, $email, $permissoes);

        header("Location: ../pages/usuarios.php");

        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $error) {
        die("Query failed: " . $error->getMessage());
    }
    
} else {
    header("Location: ../pages/cadastrarUsuario.php");
}