<?php
class Quote
{
    // DB stuff
    private $conn;
    private $table = 'quotes';

    // Category properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        // Create query
        $query = 'SELECT q.id, q.quote, a.author as author_name,
        c.category as category_name 
        FROM quotes q 
        LEFT JOIN authors a ON q.author_id = a.id 
        LEFT JOIN categories c ON q.category_id = c.id
        ORDER BY q.id ASC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        // Create query
        $query = 'SELECT q.id, q.quote, a.author as author_name,
    c.category as category_name 
      FROM quotes q 
      LEFT JOIN authors a ON q.author_id = a.id 
      LEFT JOIN categories c ON q.category_id = c.id
      WHERE q.id = ?';

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
            $this->quote = $row['quote'];
            $this->author_id = $row['author_name'];
            $this->category_id = $row['category_name'];
        }
    }
    public function create()
    {
        // query
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id)
            VALUES (:quote, :author_id, :category_id) RETURNING id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        if ($stmt->execute()) {
            // Get ID of the newly created quote
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    public function update()
    {
        // query
        $query = 'UPDATE ' . $this->table . ' 
          SET
            quote = ?,
            author_id = ?,
            category_id = ?
          WHERE
            id = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(1, $this->quote);
        $stmt->bindParam(2, $this->author_id);
        $stmt->bindParam(3, $this->category_id);
        $stmt->bindParam(4, $this->id);

        // Execute query
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    public function delete()
    {
        // Query
        $query = 'DELETE FROM ' . $this->table .
            ' WHERE id = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(1, $this->id);

        // Execute query
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}
?>