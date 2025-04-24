<?php
require 'functions.php';

$nome = $_GET['nome'];
$nome = buscarProduto($nome);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    atualizarProduto($id, $_POST['nome'], $_POST['autor'], $_POST['genero'],$_POST['preco'], $_POST['quantidade']);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filhas de D.Helena - EDIÇÃO</title>
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
    <section class="add-product">
        <form  method="post">
            <h3>Detalhes do produto</h3>            
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required maxlength="50" class="box" placeholder="Digite o nome do livro">
            <label for="autor">Autor:</label>            
            <input type="text" name="autor" required maxlength="50" class="box" placeholder="Digite o autor do livro">
            <label for="genero">Gênero:</label>
            <input type="text" name="genero" required maxlength="50" class="box" placeholder="Digite o gênero do livro">
            <label for="preco">preco:</label>
            <input type="number" name="preco" required maxlength="10" min="0" max="9999999999" class="box" placeholder="Digite o preço do livro">
            <p>Quantidade<span>*</span></p>
            <input type="number" name="quantidade" required maxlength="10" min="0" max="9999999999" class="box" placeholder="Digite quantidade do livro">           
            <input type="submit" value="Adicionar livro" class="btn" name="add_product">
        </form>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./resources/js/index.js"></script>
    
</body>
</html>