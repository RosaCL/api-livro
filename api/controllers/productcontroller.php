<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/Database.php';
require_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch($requestMethod) {
    case 'GET':
        if(!empty($_GET["id"])) {
            $product->id = $_GET["id"];
            $product->readOne();
            
            if($product->nome != null) {
                $product_arr = array(
                    "id" => $product->id,
                    "nome" => $product->nome,
                    "autor" => $product->autor,
                    "genero" => $product->genero,
                    "preco" => $product->preco,
                    "quantidade" => $product->quantidade,
                    "imagem" => $product->imagem
                );
                
                http_response_code(200);
                echo json_encode($product_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Produto não encontrado."));
            }
        } else {
            $stmt = $product->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $products_arr = array();
                $products_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    
                    $product_item = array(
                        "id" => $id,
                        "nome" => $nome,
                        "autor" => $autor,
                        "genero" => $genero,
                        "preco" => $preco,
                        "quantidade" => $quantidade,
                        "imagem" => $imagem
                    );
                    
                    array_push($products_arr["records"], $product_item);
                }
                
                http_response_code(200);
                echo json_encode($products_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Nenhum produto encontrado."));
            }
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        
        if(
            !empty($data->nome) &&
            !empty($data->autor) &&
            !empty($data->genero) &&
            !empty($data->preco) &&
            !empty($data->quantidade)
        ) {
            $product->nome = $data->nome;
            $product->autor = $data->autor;
            $product->genero = $data->genero;
            $product->preco = $data->preco;
            $product->quantidade = $data->quantidade;
            $product->imagem = $data->imagem ?? null;
            
            if($product->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Produto criado com sucesso."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Não foi possível criar o produto."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos. Não foi possível criar o produto."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        $product->id = $data->id;
        
        $product->nome = $data->nome;
        $product->autor = $data->autor;
        $product->genero = $data->genero;
        $product->preco = $data->preco;
        $product->quantidade = $data->quantidade;
        $product->imagem = $data->imagem ?? null;
        
        if($product->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Produto atualizado com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível atualizar o produto."));
        }
        break;
        
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $product->id = $data->id;
        
        if($product->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Produto excluído com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível excluir o produto."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método não permitido."));
        break;
}
?>