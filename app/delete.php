<?php
require_once('inc/config.php');
require_once('inc/api_functions.php');

$id = $_GET['id_product'];
deletarProduto($id);
header("Location: index.php");
exit;


?>