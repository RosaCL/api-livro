<?php
include '../api-livro/api/config/database.php';
if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    setcookie('user_id', create_unique_id(), time()+60*60*24*30);
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../resources/css/index.css">
</head>
<body>
    <!-- header -->
    <?php include './api/components/header.php';?>
    <!-- header -->
    <!-- adicionar produto -->
    <section class="add-product">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Detalhes do produto</h3>
            <p>Nome <span>*</span></p>
            <input type="text" name="nome" required maxlength="50" class="box" placeholder="Digite o nome do livro">
            <p>Autor <span>*</span></p>
            <input type="text" name="autor" required maxlength="50" class="box" placeholder="Digite o autor do livro">
            <p>Gênero <span>*</span></p>
            <input type="text" name="genero" required maxlength="50" class="box" placeholder="Digite o gênero do livro">
            <p>Preço<span>*</span></p>
            <input type="number" name="preco" required maxlength="10" min="0" max="9999999999" class="box" placeholder="Digite o preço do livro">
            <p>Quantidade<span>*</span></p>
            <input type="number" name="quantidade" required maxlength="10" min="0" max="9999999999" class="box" placeholder="Digite quantidade do livro">
            <p>Imagem<span>*</span></p>
            <input type="file" name="image" required accept="image/*" class="box">
            <input type="submit" value="Sdicionar livro" class="btn" name="add_product">
        </form>
    </section>
    <!-- adicionar produto -->
    <!-- ALERT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- ALERT -->
    <!-- JS -->
    <script src="../resources/js/index.js"></script>
    <!-- JS -->

    <?php include './api/components/alert.php';?>
</body>
</html>