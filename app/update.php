<?php
require_once('inc/config.php');
require_once('inc/api_functions.php');

$id=$_GET['id_product'] ?? null;
$product = buscarProduto($id);

if(!$product){
    echo "<h3> Produto não encontrado!</h3>";
    exit;
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    atualizarProduto($id, $_POST['nome'], $_POST ['autor'],$_POST ['genero'], $_POST ['preco'], $_POST ['quantidade']);
    header("Location: index.php");
    exit;
}
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
        <a href="#product">Produtos cadastrados</a>          
        <a href="#clientes">Clientes cadastrados</a>          
        </nav>
        <div id="menu-btn" class="fas fa-bars"></div>  
</header>
<section class="product" id="product">
    <div class="box">
    <h1 class="heading"> Produtos Cadastrados</h1>
    <table>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Autor</th>
                <th>Gênero</th>
                <th>Preço</th>
                <th>Quantidade</th>                
                <th>Criação</th>
            </tr>
            <?php
            $results = api_request('get_all_products', 'GET');?>
            <?php foreach($results['data']['results'] as $product) :?>
            <tr>
                <td><?=$product['id_product']?></td>
                <td><?=$product['nome']?></td>
                <td><?=$product['autor']?></td>
                <td><?=$product['genero']?></td>
                <td>R$ <?=$product['preco']?></td>
                <td><?=$product['quantidade']?></td>
                <td><?=$product['created_at']?></td>
                <td>
                <a class="btn" href="update.php?id=<?= $produto['ID_produto'] ?>">Editar</a> 
                <a class="delete-btn" href="delete.php?id=<?= $produto['ID_produto'] ?>" onclick="return confirm('Deseja deletar?')">Deletar</a>
            </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
</section> 
<section class="clientes" id="clientes">
    <div class="box">
        <h1 class="heading">Clientes Cadastrados</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Criação</th>
            </tr>
            <?php $results = api_request('get_all_clients', 'GET');?>
            <?php foreach($results['data']['results'] as $client) :?>
            <tr>
                <td><?=$client['id_client']?></td>
                <td><?=$client['name']?></td>
                <td><?=$client['email']?></td>
                <td><?=$client['phone']?></td>
                <td><?=$client['adress']?></td>
                <td><?=$client['created_at']?></td>
                <td>
                <a class="btn" href="update.php?id=<?= $produto['ID_produto'] ?>">Editar</a> 
                <a class="delete-btn" href="delete.php?id=<?= $produto['ID_produto'] ?>" onclick="return confirm('Deseja deletar?')">Deletar</a>
            </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
</section>
</body>
</html>