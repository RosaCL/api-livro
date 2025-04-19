<?php
class Product {
    private $conn;
    private $table_name = "produtos";

    public $id;
    public $nome;
    public $autor;
    public $genero;
    public $preco;
    public $quantidade;
    public $imagem;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Métodos CRUD aqui...
    
    // CREATE
    function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nome=:nome, autor=:autor, genero=:genero, 
                  preco=:preco, quantidade=:quantidade, imagem=:imagem";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
        $this->imagem = htmlspecialchars(strip_tags($this->imagem));
        
        // Bind
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":imagem", $this->imagem);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // READ (todos os produtos)
    function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // READ (um produto)
    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nome = $row['nome'];
        $this->autor = $row['autor'];
        $this->genero = $row['genero'];
        $this->preco = $row['preco'];
        $this->quantidade = $row['quantidade'];
        $this->imagem = $row['imagem'];
    }
    
    // UPDATE
    function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome=:nome, autor=:autor, genero=:genero, 
                  preco=:preco, quantidade=:quantidade, imagem=:imagem
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
        $this->imagem = htmlspecialchars(strip_tags($this->imagem));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":imagem", $this->imagem);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // DELETE
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>