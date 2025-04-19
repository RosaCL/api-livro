<?php
// Inclua o cabeçalho
include_once 'header.php';

// Processamento do formulário
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    // Processar upload da imagem
    $target_dir = "uploads/";
    if(!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Verificar se é uma imagem real
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>swal('Erro!', 'O arquivo não é uma imagem.', 'error');</script>";
        $uploadOk = 0;
    }
    
    // Verificar se o arquivo já existe
    if(file_exists($target_file)) {
        echo "<script>swal('Erro!', 'Desculpe, o arquivo já existe.', 'error');</script>";
        $uploadOk = 0;
    }
    
    // Verificar tamanho do arquivo (5MB máximo)
    if($_FILES["image"]["size"] > 5000000) {
        echo "<script>swal('Erro!', 'Desculpe, seu arquivo é muito grande.', 'error');</script>";
        $uploadOk = 0;
    }
    
    // Permitir apenas certos formatos
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>swal('Erro!', 'Desculpe, apenas JPG, JPEG, PNG e GIF são permitidos.', 'error');</script>";
        $uploadOk = 0;
    }
    
    // Verificar se $uploadOk está definido como 0 por um erro
    if($uploadOk == 0) {
        echo "<script>swal('Erro!', 'Desculpe, seu arquivo não foi enviado.', 'error');</script>";
    } else {
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Preparar dados para a API
            $data = array(
                'nome' => $_POST['nome'],
                'autor' => $_POST['autor'],
                'genero' => $_POST['genero'],
                'preco' => $_POST['preco'],
                'quantidade' => $_POST['quantidade'],
                'imagem' => $target_file
            );
            
            // Enviar para a API
            $url = 'http://localhost/projeto/api/controllers/ProductController.php';
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data)
                )
            );
            
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            
            if($result !== false) {
                echo "<script>
                    swal('Sucesso!', 'Produto adicionado com sucesso!', 'success')
                    .then(() => { window.location.href = 'produtos.php'; });
                </script>";
            } else {
                echo "<script>swal('Erro!', 'Falha ao adicionar produto via API.', 'error');</script>";
            }
        } else {
            echo "<script>swal('Erro!', 'Desculpe, houve um erro ao enviar seu arquivo.', 'error');</script>";
        }
    }
}
?>

<section class="add-product">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
        <input type="submit" value="Adicionar livro" class="btn" name="add_product">
    </form>
</section>

<?php
// Inclua o rodapé
include_once 'footer.php';
?>