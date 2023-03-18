<?php
class Category
{
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Category properties
    public $id;
    public $category;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table . ';';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        // Create query
        $query = 'SELECT *
        FROM ' . $this->table .
            ' WHERE id = ? LIMIT 1;';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind param
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row > 0) {
            $this->id = $row['id'];
            $this->category = $row['category'];
        }
    }

    public function create()
    {
        // Create query
        $query = "INSERT INTO " . $this->table . " (category)
        VALUES (?)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind param
        $stmt->bindParam(1, $this->category);

        if ($stmt->execute()) {
            // Get ID of the newly created category
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }

        // Print error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function update()
    {
        // Create query
        $query = "UPDATE " . $this->table
            . " SET  
                category = ?
            WHERE
                id = ?";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind param
        $stmt->bindParam(1, $this->category);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        // Print error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete()
    {
        // query
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameters
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>