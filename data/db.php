<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "mess";
    public $conn;

    // Constructor to establish connection
    public function __construct() {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    // Method to close connection
    public function closeConnection() {
        mysqli_close($this->conn);
    }
}
?>
