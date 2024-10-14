<?php

function selectData($query) {
    include '../src/db/dbh.php';
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $results;
    } catch (PDOException $error) {
        die("Query failed: " . $error->getMessage());
    }
}