<?php

//Inclui o arquivo  chamado como o config.php uma vez. dirname(__FILE__) retorna o diretório do script atual, garantindo que o caminho seja relativo ao script. 
require_once(dirname(__FILE__).'/inc/config.php');
require_once(dirname(__FILE__).'/inc/api_response.php');
require_once(dirname(__FILE__).'/inc/api_logic.php');
require_once(dirname(__FILE__).'/inc/database.php');


//Cria um objeto da classe api_response, permitindo que o script utilize seus métodos para construir e enviar a resposta da API.
$api_response = new api_response();

//Verificação do Método da Requisição:
if(!$api_response->check_method($_SERVER['REQUEST_METHOD']))
{
    $api_response->api_request_error('Invalid request method.');
}

//Armazena o método da requisição na instância da classe api_response, provavelmente para ser usado posteriormente na lógica da API.
// Obtenção e Definição do Endpoint e Parâmetros
$api_response->set_method($_SERVER['REQUEST_METHOD']);
$params=null;
if($api_response->get_method()=='GET'){
    $api_response->set_endpoint($_GET['endpoint']);
    $params=$_GET;
}elseif($api_response->get_method()=='POST'){
    $api_response->set_endpoint($_POST['endpoint']);
    $params=$_POST;
}

$api_logic = new api_logic($api_response->get_endpoint(),$params);


//Verificação da Existência do Endpoint:
if (!$api_logic->endpoint_exists()){
    $api_response->api_request_error('Inexistent endpoint:'.$api_response->get_endpoint());
}

$result = $api_logic->{$api_response->get_endpoint()}();
$api_response->add_do_data('data', $result);

$api_response->send_response();


?>