<?php
require_once '../../config/database.php';
require_once '../../models/registro.php';

header ("Content-Type:application/json");

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim ($_SERVER['PATH_INFO'], '/'));

$bancodadolivro=getBDConnection();
$registro= new registro($bancodadolivro);

switch ($method){
    case 'GET':
        if (isset ($request[0])&& is_numeric($request[0])){
            $registro->id=$request[0];
            $registro->read_single();

            if($registro->nome){
                echo json_encode([
                    'id'=>$registro->id,
                    'nome'=>$registro->nome,
                    'autor'=>$registro->autor,
                    'genero'=>$registro->genero
                ]);
            }else{
                http_response_code(404);
                echo json_encode(['message' => 'Registro não encontrado']);
            }
        }else{
            $stmt = $registro->read();
            $registro_arr=array();

            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                $registro_arr[]=[
                    'id'=>$row['id'],
                    'nome'=>$row['nome'],
                    'autor'=>$row['autor'],
                    'genero'=>$row['genero']
                ];
            }
            echo json_encode($registro_arr);
        }
        break;
    case 'POST':
        // POST /registro
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nome)) {
            $registro->nome = $data->nome;
            $registro->autor = $data->autor ?? '';
            $registro->genero = $data->genero ?? false;

            if ($registro->create()) {
                http_response_code(201);
                echo json_encode(['message' => 'registro criado']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'registro não criado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'O título é obrigatório']);
        }
        break;

    case 'PUT':
        // PUT /registros/{id}
        if (isset($request[0]) && is_numeric($request[0])) {
            $registro->id = $request[0];
            $data = json_decode(file_get_contents("php://input"));

            $registro->nome = $data->nome ?? null;
            $registro->autor = $data->autor ?? null;
            $registro->genero = $data->genero ?? null;

            if ($registro->update()) {
                echo json_encode(['message' => 'Registro atualizado']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'Registro não atualizado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de registro inválido']);
        }
        break;

    case 'DELETE':
        // DELETE /registros/{id}
        if (isset($request[0]) && is_numeric($request[0])) {
            $registro->id = $request[0];

            if ($registro->delete()) {
                echo json_encode(['message' => 'Registro excluído']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'Registro não excluído']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de registro inválido']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Método não permitido']);
        break;
}

?>