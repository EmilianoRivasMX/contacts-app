<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['HOST'];
$db   = $_ENV['DB'];
$user = $_ENV['USER'];
$password = $_ENV['PWD'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch(PDOException $error) {
    die("PDO Connection Error: " . $error->getMessage());
}