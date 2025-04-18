<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    setcookie('user_id', create_unique_id(), time()+60*60*24*30);
}

if(isset($_POST['add_product'])){
    $id=create_unique_id();
    $name=$_POST['nome'];
    $name=filter_var($name, FILTER_SANITIZE_STRING);

    $autor=$_POST['autor'];
    $autor=filter_var($autor, FILTER_SANITIZE_STRING);

    $genero=$_POST['genero'];
    $genero=filter_var($genero, FILTER_SANITIZE_STRING);

    $preco=$_POST['preco'];
    $preco=filter_var($preco, FILTER_SANITIZE_STRING);

    $quantidade=$_POST['quantidade'];
    $quantidade=filter_var($quantidade, FILTER_SANITIZE_STRING);

    $image=$_POST['image']['nome'];
    $image=filter_var($image, FILTER_SANITIZE_STRING);

    $ext=pathinfo($image, PATHINFO_EXTENSION);
    $rename=create_unique_id().'.'.$ext;
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_size=$_FILES['image']['size'];
    $image_folder='upload_files/'.$rename;


    if($image_size>2000000){
        $warning_msg[]= 'Imagem muito grande!';
    }else{
        $insert_product=$conn->prepare("INSERT INTO `products`(id, name, autor, genero, preco, quantidade, image) VALUES(?,?,?,?,?,?,?)");
        $insert_product->execute([$id,$name, $autor,$genero,$preco,$quantidade,$rename]);
        $sucess_msg[]='Produto registrado!';
        move_uploaded_file($image_tmp_name,$image_folder);
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filhas de D.Helena</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <!-- header -->
    <?php include 'components/header.php';?>
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
    <script src="../js/index.js"></script>
    <!-- JS -->

    <?php include './api/components/alert.php';?>
</body>
</html>