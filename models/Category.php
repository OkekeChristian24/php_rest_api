<?php
class Category{
    
    // DB interaction
    private $conn;
    private $table = 'categories';
    
    // Post parameters
    public $id;
    public $name;
    public $created_at;
    
    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }
    
    // Get all categories
    public function read_all(){
        // Create query
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        
        // Execute Query
        $stmt->execute();
        
        return $stmt;
    }
    
    // Get one category
    public function read_single(){
        // Create query
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 0,1';
        
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind the parameter
        $stmt->bindParam(':id', $this->id);
        
        // Execute
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row == null){
            die("No Category Found For ID " . $this->id);
        }else{
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];
        }
    }
    
    public function create(){
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean incoming data
        $this->name = htmlspecialchars(strip_tags($this->name));
        
        // Bind parameter
        $stmt->bindParam(':name', $this->name);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        
        // Print error message if something goes wrong
        printf('Execution failed %s.\n', $stmt->error);
        return false;
    }
    
    public function update(){
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean incoming data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parameter
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        
        // Print error message if something goes wrong
        printf('Execution failed %s.\n', $stmt->error);
        return false;
    }
    
    
    public function delete(){
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind the parameter
        $stmt->bindParam(':id', $this->id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        
        // Print error message if something goes wrong
        printf('Execution failed %s.\n', $stmt->error);
        return false;
        
        
    }
    
    
    
    
    
    
}


?>