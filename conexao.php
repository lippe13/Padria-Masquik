<?php
$host = '127.0.0.1'; // host
$dbname = 'a2023951571@teiacoltec.org'; // database
$user = 'a2023951571@teiacoltec.org'; //user
$pass = '@Coltec2024'; //senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>
