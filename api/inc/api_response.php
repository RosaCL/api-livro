<?php

//Esta é a definição da classe api_response em PHP. Esta classe tem como objetivo encapsular a lógica para construir e enviar respostas de uma API, geralmente no formato JSON
class api_response
{
//Esta linha declara uma propriedade privada chamada $data. A palavra-chave private significa que essa variável só pode ser acessada e modificada dentro da própria classe api_response. Ela provavelmente será usada para armazenar os dados que serão incluídos na resposta da API.
    private $data;
    private $available_methods=['GET', 'POST'];


//Este é o construtor da classe. O método __construct() é um método especial que é chamado automaticamente quando um novo objeto da classe api_response é criado (instanciado).
//Dentro do construtor, $this->data = []; inicializa a propriedade $data como um array vazio. Isso garante que, ao criar um novo objeto api_response, o array de dados comece vazio.
    public function __construct()
    {
        $this->data=[];
    }



    public function check_method($method)
    {
        return in_array($method, $this->available_methods);
    }

    public function set_method($method)
    {
        $this->data['method']=$method;
    }

    public function get_method()
    {
        return $this->data['method'];
    }

    public function set_endpoint($endpoint)
    {
        $this->data['endpoint'] = $endpoint;
    }
    public function get_endpoint()
    {
        return $this->data['endpoint'];
    }

    public function add_do_data($key, $value)
    {
        $this->data[$key]=$value;
    }

    public function api_request_error($message='')
    {
        $data_error=[
            'status'=> 'ERROR',
            'message'=>$message,
            'results'=>null
        ];
        $this->data['data']=$data_error;
        $this->send_response();
    }

    public function send_api_status()
    {
        $this->data['status']='SUCESS';
        $this->data['message']='API is running ok!';
        $this->send_response();
    }

    public function send_response()
    {
        //header("Content-Type:application/json"); define o cabeçalho HTTP Content-Type como application/json. Isso informa ao cliente (quem fez a requisição) que a resposta está no formato JSON.
        header("Content-Type:application/json");
        // função json_encode() do PHP para converter o array $this->data em uma string JSON. Essa string JSON é então enviada como o corpo da resposta HTTP.
        echo json_encode($this->data);
        die(1);
    }
}
?>