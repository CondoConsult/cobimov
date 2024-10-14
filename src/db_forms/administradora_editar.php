<?php

require_once '../db/dbh.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $button= $_POST['button'];
    $administradoraID = intval($_POST['administradoraID']);

    if ($button === "update") {
        updateData($pdo, $administradoraID);
    } else {
        removeData($pdo, $administradoraID);
    }

} else {
    header("Location: ../../pages/editarAdministradora.php");
}

function updateData($pdo, $administradoraID) {
    $nome = htmlspecialchars($_POST['nome']);
    $endereco = htmlspecialchars($_POST['endereco']);
    $email = htmlspecialchars($_POST['email']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $celular = htmlspecialchars($_POST['celular']);
    $emailMoradores = htmlspecialchars($_POST['email-moradores']);
    $dddMoradores = htmlspecialchars($_POST['ddd-moradores']);
    $telefoneMoradores = htmlspecialchars($_POST['telefone-moradores']);
    $celularMoradores = htmlspecialchars($_POST['celular-moradores']);
    $observacoes = htmlspecialchars($_POST['observacoes']);

    $query = "UPDATE Administradoras SET
            Nome = :nome,
            Endereco = :endereco,
            Telefone = :telefone,
            Celular = :celular,
            Email = :email,
            TelefoneParaMoradores = :telefonemoradores,
            CelularParaMoradores = :celularmoradores,
            EmailParaMoradores = :emailmoradores,
            Observacoes = :observacoes
            WHERE AdministradoraID = :administradoraid;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":administradoraid", $administradoraID);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":endereco", $endereco);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":celular", $celular);
    $stmt->bindParam(":telefonemoradores", $telefoneMoradores);
    $stmt->bindParam(":celularmoradores", $celularMoradores);
    $stmt->bindParam(":emailmoradores", $emailMoradores);
    $stmt->bindParam(":observacoes", $observacoes);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroAtualizado('consultarAdministradora');
    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;

    die();
}

function removeData($pdo, $administradoraID) {
    $query = "DELETE FROM Administradoras WHERE AdministradoraID = :administradoraid;";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(":administradoraid", $administradoraID);

    if ($stmt->execute()) {
        include_once '../../public/partials/messages.php';
        cadastroRemovido();
    } else {
        echo "error";
    }

}