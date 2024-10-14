<?php

$dsn = "mysql:host=162.241.218.184;dbname=unsbjlmy_cobimov";
$dbUsername = "unsbjlmy_cobimov";
$dbPassword = "unsbjlmy_cobimov";

/* $dsn = "mysql:host=localhost;dbname=CobImov Local";
$dbUsername = "root";
$dbPassword = ""; */

try {
   $pdo = new PDO($dsn, $dbUsername, $dbPassword);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
   echo "Connection failed: " . $error->getMessage();
}