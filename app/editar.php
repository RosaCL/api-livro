<?php
include_once 'header.php';

// Verificar se o ID foi passado
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: produtos.php");
    exit;
}

$productId = $_GET['id'];

// Buscar dados do produto
$url = 'http://localhost/projeto/api/controllers/ProductController.php?id=' . $productId;
$productData = file_get_contents($url);
$product = json_decode($productData, true);

if(!$product || !isset($product['id'])) {
    echo "<script>swal('Erro!', 'Produto não encontrado.', 'error').then(() => { window.location.href = 'produtos.php'; });</script>";
    exit;
}

// Processamento do formulário de edição
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_product"])) {
    $data = array(
        'id' => $productId,
        'nome' => $_POST['nome'],
        'autor' => $_POST['autor'],
        'genero' => $_POST['genero'],
        'preco' => $_POST['preco'],
        'quantidade' => $_POST['quantidade'],
        'imagem' => $product['imagem'] // Mantém a imagem original por padrão
    );
    
    // Processar upload da nova imagem se fornecida
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Verificações (como no cadastro.php)
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $data['imagem'] = $target_file;
            }
        }
    }
    
    // Enviar para a API
    $url = 'http://localhost/projeto/api/controllers/ProductController.php';
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'PUT',
            'content' => json_encode($data)
        )
    );
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if($result !== false) {
        echo "<script>
            swal('Sucesso!', 'Produto atualizado com sucesso!', 'success')
            .then(() => { window.location.href = 'produtos.php'; });
        </script>";
    } else {
        echo "<script>swal('Erro!', 'Falha ao atualizar produto via API.', 'error');</script>";
    }
}
?>

<section class="edit-product">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $productId; ?>" method="post" enctype="multipart/form-data">
        <h3>Editar produto</h3>
        <p>Nome <span>*</span></p>
        <input type="text" name="nome" required maxlength="50" class="box" 
               value="<?php echo htmlspecialchars($product['nome']); ?>" placeholder="Digite o nome do livro">
        <p>Autor <span>*</span></p>
        <input type="text" name="autor" required maxlength="50" class="box" 
               value="<?php echo htmlspecialchars($product['autor']); ?>" placeholder="Digite o autor do livro">
        <p>Gênero <span>*</span></p>
        <input type="text" name="genero" required maxlength="50" class="box" 
               value="<?php echo htmlspecialchars($product['genero']); ?>" placeholder="Digite o gênero do livro">
        <p>Preço<span>*</span></p>
        <input type="number" name="preco" required maxlength="10" min="0" max="9999999999" class="box" 
               value="<?php echo htmlspecialchars($product['preco']); ?>" placeholder="Digite o preço do livro">
        <p>Quantidade<span>*</span></p>
        <input type="number" name="quantidade" required maxlength="10" min="0" max="9999999999" class="box" 
               value="<?php echo htmlspecialchars($product['quantidade']); ?>" placeholder="Digite quantidade do livro">
        <p>Imagem</p>
        <div class="current-image">
            <img src="<?php echo htmlspecialchars($product['imagem']); ?>" alt="Imagem atual" style="max-width: 200px; margin-bottom: 10px;">
        </div>
        <input type="file" name="image" accept="image/*" class="box">
        <small>Deixe em branco para manter a imagem atual</small>
        <input type="submit" value="Atualizar livro" class="btn" name="update_product">
    </form>
</section>

<?php
include_once 'footer.php';
?>