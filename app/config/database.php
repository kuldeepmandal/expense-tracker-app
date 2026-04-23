<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Prajwan
 * @description Configuration layer.
 */
/**
 * Class Database
 * Handles the application's PDO database connection.
 */
class Database {
    private $host = '127.0.0.1';
    private $db_name = 'spendly_db';
    private $username = 'root';
    private $password = '';
    public $conn;

    /**
     * Establishes and returns the database connection.
     *
     * @return PDO|null Returns the active PDO connection or null on error.
     */
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
