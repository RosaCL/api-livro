<?php
// Conexão com o banco
$db_name = 'mysql:host=localhost;dbname=registro_livro';
$db_user_name = 'mrcl';
$db_user_pass = 'P67a31kEJI4eveGECAV15iJEbiriHI';

$conn = new PDO($db_name, $db_user_name, $db_user_pass);

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
<header class="header">
    <section class="flex">
        <a href="add_product.php" class="logo">Filhas de D.Helena</a>
        <nav class="navbar">
            <a href="../cadastro.html">Adicionar produtos</a>
            <a href="./components/view_product.php">Todos os produtos</a>           
        </nav>
        <div id="menu-btn" class="fas fa-bars"></div>
    </section>
</header>
    <section class="add-product">
        <div class="box">
        <?php
        // Função para gerar ID único
    function create_unique_id() {
        $characters = 'P67a31kEJI4eveGECAV15iJEbiriHI';
        $characters_length = strlen($characters);
        $random = '';
        for ($i = 0; $i < 30; $i++) {
            $random .= $characters[mt_rand(0, $characters_length - 1)];
        }
        return $random;
    }

    // Verifica se o usuário tem um cookie
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
    }

    // Inserção de produto
    if (isset($_POST['add_product'])) {
        $id = create_unique_id();
        $name = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
        $autor = filter_var($_POST['autor'], FILTER_SANITIZE_STRING);
        $genero = filter_var($_POST['genero'], FILTER_SANITIZE_STRING);
        $preco = filter_var($_POST['preco'], FILTER_SANITIZE_STRING);
        $quantidade = filter_var($_POST['quantidade'], FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id() . '.' . $ext;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = 'upload_files/' . $rename;

        if ($image_size > 2000000) {
            $warning_msg[] = 'Imagem muito grande!';
        } else {
            $insert_product = $conn->prepare("INSERT INTO `products`(id, name, autor, genero, preco, quantidade, image) VALUES(?,?,?,?,?,?,?)");
            if ($insert_product->execute([$id, $name, $autor, $genero, $preco, $quantidade, $rename])) {
                $sucess_msg[] = 'Produto registrado!';
                move_uploaded_file($image_tmp_name, $image_folder);
            } else {
                $warning_msg[] = 'Erro ao registrar o produto.';
            }
        }
    }
?>

        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/index.js"></script>
    <?php include './api/components/alert.php';?>
</body>
</html>