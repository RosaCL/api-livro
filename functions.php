<?php
require_once 'database.php';

function salvarEmJSON($dados) {
    file_put_contents('data.json', json_encode($dados, JSON_PRETTY_PRINT));
}

function listarProdutos() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM registro");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    salvarEmJSON($produtos);
    return $produtos;
}

function cadastrarProduto($nome, $autor, $genero, $preco, $quantidade) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO registro (nome, autor, genero, preco, quantidade) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $autor, $genero, $preco, $quantidade]);
}

function buscarProduto($nome) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM registro WHERE nome = ?");
    $stmt->execute([$nome]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function atualizarProduto($id,$nome, $autor, $genero, $preco, $quantidade) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE registro SET name = ?, nome = ? WHERE id = ?");
    $stmt->execute([$nome, $autor, $genero, $preco, $quantidade, $id]);
}

function deletarProduto($nome) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM registro WHERE nome = ?");
    $stmt->execute([$nome]);
}