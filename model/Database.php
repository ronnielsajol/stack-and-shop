<?php
class Database {
    private $conn;
    
    public function __construct() {
        require_once 'Config.php';
        $this->conn = $conn;
    }

    public function getConnection() {
        return $this->conn;
    }
}