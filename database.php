<?php
$host = 'localhost';
$db = 'registro_livro';
$user = 'mrcl';
$pass = 'P67a31kEJI4eveGECAV15iJEbiriHI';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}