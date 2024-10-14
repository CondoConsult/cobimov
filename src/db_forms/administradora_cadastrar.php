<?php

require_once '../db/dbh.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $email = isset($_POST['email-administradora']) ? $_POST['email-administradora'] : array();
    $telefone = isset($_POST['telefone-administradora']) ? $_POST['telefone-administradora'] : array();
    $celular = isset($_POST['celular-administradora']) ? $_POST['celular-administradora'] : array();
    $emailMoradores = isset($_POST['email-moradores']) ? $_POST['email-moradores'] : array();
    $telefoneMoradores = isset($_POST['telefone-moradores']) ? $_POST['telefone-moradores'] : array();
    $celularMoradores = isset($_POST['celular-moradores']) ? $_POST['celular-moradores'] : array();
    $observacoes = $_POST['observacoes'];
    $email = implode(' - ' , $email);
    $telefone = implode(' - ' , $telefone);
    $celular = implode(' - ' , $celular);
    $emailMoradores = implode(' - ' , $emailMoradores);
    $telefoneMoradores = implode(' - ' , $telefoneMoradores);
    $celularMoradores = implode(' - ' , $celularMoradores);

    $query = "INSERT INTO Administradoras (Nome, Endereco, Telefone, Email, Celular, TelefoneParaMoradores, CelularParaMoradores, EmailParaMoradores, Observacoes)
    VALUES (:nome, :endereco, :telefone, :email, :celular, :telefonemoradores, :celularmoradores, :emailmoradores, :observacoes);";
   
    $stmt = $pdo->prepare($query);

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
        cadastroEfetuado();
    } else {
        echo "error";
    }

    $pdo = null;
    $stmt = null;

    die();

} else {
    header('Location: ../../pages/cadastrarAdministradora.php',true);
}