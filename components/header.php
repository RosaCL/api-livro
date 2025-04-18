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