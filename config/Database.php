<?php
class Database
{
    // DB params
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    // DB connect
    public function connect()
    {
        $this->host = getenv("HOST");
        $this->port = getenv("PORT");
        $this->db_name = getenv("DB_NAME");
        $this->username = getenv("USERNAME");
        $this->password = getenv("PASSWORD");
        $this->conn = null;
        $dsn = 'pgsql:host=' . $this->host . ';port=' . $this->port .
            ';dbname=' . $this->db_name;
        try {
            $this->conn = new PDO(
                $dsn,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>