<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../db/dbh.php';

        $button = $_POST['button'];

        switch ($button) {
            case 'insert':
                
                break;

            case 'delete':

                break;
        }
    } else {
        header('Location: ../pages/home');
    }

    function insert($pdo) {
        try {
            
            $query = '';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam('',);

            if (!$stmt->execute()) {
                echo "error";
            }

            header('Location: ');
            $pdo = null;
            $stmt = null;
            die();

        } catch (PDOException $error) {
            die('Query failed: ' . $error->getMessage());
        }
    }