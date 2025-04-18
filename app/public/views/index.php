<?php
include './config/database.php';
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
    <link rel="stylesheet" href="./resources/css/index.css">
</head>
<body>
    <!-- header -->
    <?php include './components/header.php';?>
    <!-- header -->

    
    <!-- JS -->
    <script src="./resources/js/index.js"></script>
    <!-- JS -->
</body>
</html>