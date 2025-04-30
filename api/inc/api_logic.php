<?php

//Esta linha declara uma nova classe chamada api_logic. Classes em PHP são como "moldes" para criar objetos, que são instâncias da classe e podem conter dados (propriedades) e funcionalidades (métodos).
class api_logic


{
    //private $endpoint;: Esta linha declara uma propriedade privada chamada $endpoint. A palavra-chave private significa que esta propriedade só pode ser acessada de dentro da própria classe api_logic. Provavelmente, esta propriedade armazenará o nome da função (ou "endpoint") da API que será chamada.
    private $endpoint;

    //private $params;: Esta linha declara outra propriedade privada chamada $params. Ela provavelmente armazenará quaisquer parâmetros que sejam passados para a chamada da API.
    private $params;



    //Ele é chamado automaticamente quando um novo objeto da classe api_logic é criado (usando a palavra-chave new).
    //Ele é chamado automaticamente quando um novo objeto da classe api_logic é criado (usando a palavra-chave new).
    //__construct: É um nome especial reservado para o construtor em PHP.

    public function __construct($endpoint,$params=null)
    {
        //$endpoint: Este é um parâmetro que o construtor recebe. Ele será usado para inicializar a propriedade $this->endpoint.
        //$params=null: Este é outro parâmetro, com um valor padrão de null. Isso significa que, ao criar um objeto api_logic, você pode ou não passar um valor para os parâmetros. Ele será usado para inicializar a propriedade $this->params.        
        $this->endpoint=$endpoint;
        $this->params=$params;
    }


    //public function endpoint_exists(): Este método público verifica se o "endpoint" (o nome de uma função) armazenado na propriedade $this->endpoint realmente existe como um método dentro da classe api_logic.
    public function endpoint_exists()
    {
        return method_exists($this, $this->endpoint);
    }

public function status()
{
    return[
        'status'=>'SECESS',
        'message'=>'API is running ok!',
        'results'=>null
    ];
}

    //public function get_all_clients(): Este método público é responsável por buscar todos os clientes de um banco de dados.
    public function get_all_clients()
    {
        $db = new database();
        //$results=$db->EXE_QUERY("SELECT * FROM clientes");: Esta linha chama um método chamado EXE_QUERY() no objeto $db, passando uma consulta SQL (SELECT * FROM clientes). Esta consulta busca todos os dados da tabela chamada clientes no banco de dados. O resultado da consulta é armazenado na variável $results.
        $results=$db->EXE_QUERY("SELECT * FROM client");

        // O método retorna um array associativo (um tipo de array que usa strings como chaves). Este array contém informações sobre o resultado da operação
        return [
            'status'=>'SUCESS',
            'message'=>'',
            'results'=>$results
        ];
    }


    public function get_all_products()
    {
        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM product");
        return[
            'status'=>'SUCESS',
            'message'=>'',
            'results'=>$results
        ];
    }
}


?>