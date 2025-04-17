<?php
class registro {
    private $conect;
    private $table = 'registro';
    private $created_at;
    private $update_at;
    private $delete_at;


    public $id;
    public $nome;
    public $autor;
    public $genero;

    public function __construct($bancodadolivro){
        $this->conect = $bancodadolivro;
    }

    //CRUD
    // Ler todos os registros
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conect->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    // Ler um único registro
    public function read_single() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conect->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->autor = $row['autor'];
            $this->genero = $row['genero'];
        }
    }
    //Criar registro
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                    SET nome = :nome, autor = :autor, genero = :genero";

        $stmt = $this->conect->prepare($query);
        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->genero = htmlspecialchars(strip_tags($this->genero));

        // Vincular parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':autor', $this->autor);
        $stmt->bindParam(':genero', $this->genero);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    // Atualizar registro
    public function update() {
        $query = "UPDATE " . $this->table . "
                    SET nome = :nome, autor = :autor, genero = :genero
                    WHERE id = :id";

        $stmt = $this->conect->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':autor', $this->autor);
        $stmt->bindParam(':genero', $this->genero);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Deletar registro
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conect->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>

