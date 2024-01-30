<?php
class DB {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $db =  "todophp";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->db);
        if ($this->conn->connect_error) {
            die("Connection error: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
