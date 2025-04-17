<?php
class registro{
    private $conect;
    private $table = 'registro';
    private $created_at;
    private $update_at;
    private $delete_at;


    public $id;
    public $nome;
    public $autor;
    public $genero;

    public fuction __construct ($bancodadolivro){
        $this->conect = $bancodadolivro;
    }
}

?>