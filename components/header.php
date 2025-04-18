<header class="header">
    <section class="flex">
        <a href="../app/index.php" class="logo">Filhas de D.Helena</a>
        <nav class="navbar">
            <a href="../app/public/views/add_product.php">Adicionar produtos</a>
            <a href="../app/public/views/view_product.php">Todos os produtos</a>
            <a href="../app/public/views/orders.php">Seleção de produtos</a>
            <?php
            $count_cart_items=$conn->prepare("SELECT * FROM `cart` WHERE user_id=?" );
            $count_cart_items->execute([user_id]);
            $total_cart_items=$count_cart_items->rowCount();
            ?>
            <a href="../app/public/views/shoping_cart.php">cart <span><?=$total_cart_items;?></span></a>
            <a href="../app/public/views/add_product.php">Adicionar produtos</a>
        </nav>

    </section>

</header>