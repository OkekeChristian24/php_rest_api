<?php
class Post{
    // DB Interaction
    private $conn;
    private $table = 'posts';
    
    // Post Parameters
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    
    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    
    }
    
    // Get or Read Posts
    public function read(){
        // Create Query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';
        
       
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        
        // Execute Query
        $stmt->execute();
        
        return $stmt;
    }
    
    public function read_single(){
        // Create query for one post
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author,           p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                WHERE p.id = ?
                                LIMIT 0,1';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Bind the ID
        $stmt->bindParam(1, $this->id);
        
        // Execute query
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row == null){
            die('No Post Found For ID ' .$this->id);
        }else{
            // Set parameters
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }
    }
    
    // Create a post
    public function create(){
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean the incoming data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        
        // Bind the named parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        
        // Print error message if something goes wrong
        printf("Execution failed: %s.\n", $stmt->error);
        //echo 'Execution failed: ' . $stmt->error;
        return false;
    }
    
    // Update a post
    public function update(){
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id WHERE id = :id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean the incoming data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));    
        
        // Bind the named parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        
        // Print error message if something goes wrong
        printf("Execution failed: %s.\n", $stmt->error);
        //echo 'Execution failed: ' . $stmt->error;
        return false;
    }
    
    public function delete(){
        // Create query
        $query = 'DELETE FROM '.$this->table.' WHERE id = :id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean the ID
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind the id
        $stmt->bindParam(':id', $this->id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        
        // Print error message if something goes wrong
        printf("Execution failed: %s.\n", $stmt->error);
        //echo 'Execution failed: ' . $stmt->error;
        return false;
        
    }
    
}
?>