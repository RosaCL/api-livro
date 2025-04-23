<?php
require 'functions.php';

$nome = $_GET['nome'];
deletarProduto($nome);
header("Location: index.php");
exit;