<?php
// Conexão com o banco
$db_name = 'mysql:host=localhost;dbname=registro_livro';
$db_user_name = 'mrcl';
$db_user_pass = 'P67a31kEJI4eveGECAV15iJEbiriHI';

$conn = new PDO($db_name, $db_user_name, $db_user_pass);

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



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = create_unique_id();
    setcookie('user_id', $user_id, time() + 60 * 60 * 24 * 30);
}

if (isset($_POST['add_to_cart'])) {
    $id = create_unique_id();
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=? AND product_id=?");
    $verify_cart->execute([$user_id, $product_id]);

    $max_cart_itens = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
    $max_cart_itens->execute([$user_id]);

    if ($verify_cart->rowCount() > 0) {
        $warning_msg[] = 'Já adicionado!';
    } elseif ($max_cart_itens->rowCount() >= 10) {
        $warning_msg[] = 'Carrinho cheio';
    } else {
        $select_p = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
        $select_p->execute([$product_id]);
        $fetch_p = $select_p->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_p['price'], $qty]);

        $success_msg[] = 'Adicionado ao carrinho!';
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
<header class="header">
    <section class="flex">
        <a href="add_product.php" class="logo">Filhas de D.Helena</a>
        <nav class="navbar">
            <a href="add_product.php">Adicionar produtos</a>
            <a href="view_product.php">Todos os produtos</a>
            <a href="view_order.php">Seleção de produtos</a>
            <?php
            $count_cart_items=$conn->prepare("SELECT * FROM `cart` WHERE user_id=?" );
            $count_cart_items->execute([$user_id]);
            $total_cart_items=$count_cart_items->rowCount();
            ?>
            <a href="shoping_cart.php">cart <span><?=$total_cart_items;?></span></a>            
        </nav>
        <div id="menu-btn" class="fas fa-bars"></div>

    </section>

</header>
    <!-- visualização produto -->
    <section class="product">
        <h1 class="heading">Todos os produtos</h1>
        <div class="box-container">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();

            if ($select_products->rowCount() > 0) {
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <img src="upload_files/<?= $fetch_product['image']; ?>" class="image">
                    <h3 class="name"><?= $fetch_product['name']; ?></h3>
                    <div class="flex">
                        <p class="price"><i class="fa-solid fa-brazilian-real-sign"></i><?= $fetch_product['price']; ?></p>
                        <input type="number" name="qty" class="qty" maxlength="2" min="1" max="99" required>
                    </div>
                    <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="delete-btn">Compre</a>
                    <input type="submit" value="Adicione o livro" class="btn" name="add_to_cart">
                </form>
            <?php
                }
            } else {
                echo '<p class="empty">Livro não encontrado!</p>';
            }
            ?>
        </div>
    </section>
    
    <!-- ALERT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- JS -->
    <script src="../js/index.js"></script>
    <!-- Mensagens de alerta -->
    <?php include './api/components/alert.php';?>
</body>
</html>
