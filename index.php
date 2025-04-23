<?php
require 'functions.php';
$produtos = listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filhas de D.Helena</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./resources/css/index.css">
</head>
<body>
<header class="header">    
        <a href="#" class="logo">Filhas de D.Helena</a>
        <nav class="navbar">
        <a href="./create.php">Adicionar produtos</a>
        <a href="./index.php">Todos os produtos</a>          
        </nav>
        <div id="menu-btn" class="fas fa-bars"></div>  
</header>
<section class="product">
    <div class="box">
    <h1 class="heading"> Produtos Cadastrados</h1>
    <table cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Autor</th>
            <th>Gênero</th>
            <th>Preço</th>
            <th>Quantidade</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
            <td><?= $produto['id'] ?></td>
            <td><?= $produto['nome'] ?></td>
            <td><?= $produto['autor'] ?></td>
            <td><?= $produto['genero'] ?></td>
            <td><?= $produto['preco']?></td>
            <td><?= $produto['quantidade']?></td>
            <td>
                <a class="btn" href="update.php?id=<?= $produto['nome'] ?>">Editar</a> 
                <a class="delete-btn" href="delete.php?id=<?= $produto['nome'] ?>" onclick="return confirm('Deseja deletar?')">Deletar</a>
            </td>
            </tr>
            <?php endforeach; ?>
    </table>
    </div>
</section>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./resources/js/index.js"></script>
    
</body>
</html>