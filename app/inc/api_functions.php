<?php

function api_request($endpoint, $method = 'GET', $variables =[]){
    $client=curl_init();

    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $url=API_BASE_URL;

    if($method=='GET'){
        $url.="?endpoint=$endpoint";
        if(!empty($variables)){
            $url .= "&" .http_build_query($variables);
        }
    }



    if($method=='POST'){
        $variables=array_merge(['endpoint'=>$endpoint], $variables);
        curl_setopt($client, CURLOPT_POSTFIELDS, $variables);
    }

    curl_setopt($client, CURLOPT_URL, $url);

    $response=curl_exec($client);
    return json_decode($response,true);
}

function buscarProduto($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    function atualizarProduto($id, $nome, $autor, $genero, $preco, $quantidade) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, autor = ?, genero = ?, preco= ?, quantidade = ? WHERE id_product = ?");
    $stmt->execute([$nome, $autor, $genero ,$preco, $quantidade, $id]);
}

    function cadastrarProduto($nome, $autor, $genero, $preco, $quantidade) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, autor, genero, preco, quantidade) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $autor, $genero, $preco, $quantidade]);
}

    function deletarProduto($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM product WHERE id_product = ?");
    $stmt->execute([$id]);
}



?>