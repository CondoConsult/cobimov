<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    try {
        require_once '../src/db/dbh.php';
        require_once 'loginModel.php';
        require_once 'loginContr.php';

        $errors = [];

        if (isInputEmpty($usuario, $senha)) {
            $errors["empty_input"] = "Por favor, preencha todos os campos.";
        } else {
            $result = getUser($pdo, $usuario, $senha);

            if (isUsernameWrong($result)) {
                $errors["incorrect_login"] = "Verifique o usuario.";
            } elseif (isPasswordWrong($senha, $result['Senha'])) {
                $errors["incorrect_login"] = "Verifique o usuario ou a senha.";
            }
        }

        require_once 'configSession.php';

        if ($errors) {
            session_start();
            $_SESSION["errors_login"] = $errors;
            header("Location: ../index.php?error=incorrect");
            exit();
        }

        // Regenerate session ID and start a new session
        session_start();
        session_regenerate_id(true);

        $_SESSION["user_id"] = $result["UsuarioID"];
        $_SESSION["user_username"] = htmlspecialchars($result["Usuario"]);
        $_SESSION["account_type"] = htmlspecialchars($result["Permissoes"]);
        $_SESSION["last_regeneration"] = time();

        header("Location: ../index.php?login=success");
        exit();

    } catch (PDOException $error) {
        // Log the error message
        error_log("Query failed: " . $error->getMessage());
        die("An error occurred. Please try again later.");
    }

} else {
    header("Location: ../index.php");
    exit();
}