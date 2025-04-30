<?php
require_once('inc/config.php');
require_once('inc/api_functions.php')
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filhas de D.Helena</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./inc/resources/css/index.css">
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
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Autor</th>
            <th>Gênero</th>
            <th>Preço</th>
            <th>Quantidade</th>
        </tr>
        <?php
        $results = api_request('get_all_products', 'GET');?>
        <?php foreach($results['data']['results'] as $product) :?>
            <tr>
            <td><?= $product['id_product'] ?></td>
            <td><?= $product['nome'] ?></td>
            <td><?= $product['autor'] ?></td>
            <td><?= $product['genero'] ?></td>
            <td>R$ <?= $product['preco']?></td>
            <td><?= $producto['quantidade']?></td>
            <td>
                <a class="btn" href="update.php?id=<?= $product['id'] ?>">Editar</a> 
                <a class="delete-btn" href="delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Deseja deletar?')">Deletar</a>
            </td>
            </tr>
            <?php endforeach; ?>
    </table>
    </div>
</section> 
</body>
</html>