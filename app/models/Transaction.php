<?php
require_once 'app/config/database.php';

class Transaction {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addTransaction($userId, $type, $amount, $category, $description) {
        $query = "INSERT INTO transactions (user_id, type, amount, category, description, transaction_date) 
                  VALUES (:user_id, :type, :amount, :category, :description, CURDATE())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }

    public function getRecent($userId, $limit = 4) {
        $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_date DESC, id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAll($userId) {
        $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_date DESC, id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCurrentMonthSummary($userId, $month = null) {
        if (!$month) $month = date('Y-m');
        $query = "SELECT type, SUM(amount) as total FROM transactions 
                  WHERE user_id = :user_id AND DATE_FORMAT(transaction_date, '%Y-%m') = :month
                  GROUP BY type";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        $summary = ['income' => 0, 'expense' => 0];
        foreach($results as $row) {
            if($row['type'] == 'income') {
                $summary['income'] = $row['total'];
            } else {
                $summary['expense'] = $row['total'];
            }
        }
        return $summary;
    }
    public function getExpensesByCategory($userId, $month = null) {
        if (!$month) $month = date('Y-m');
        $query = "SELECT category, SUM(amount) as total FROM transactions 
                  WHERE user_id = :user_id AND type = 'expense' 
                  AND DATE_FORMAT(transaction_date, '%Y-%m') = :month
                  GROUP BY category";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        
        $results = [];
        foreach($stmt->fetchAll() as $row) {
            $results[$row['category']] = $row['total'];
        }
        return $results;
    }
}
?>
