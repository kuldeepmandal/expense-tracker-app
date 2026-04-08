<?php
require_once 'app/config/database.php';

class Budget {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function setCategoryLimit($userId, $category, $limitAmount, $month = null) {
        if (!$month) $month = date('Y-m');
        
        // Check if exists
        $query = "SELECT id FROM budgets WHERE user_id = :user_id AND category = :category AND month = :month";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Update
            $row = $stmt->fetch();
            $updateQuery = "UPDATE budgets SET limit_amount = :limit_amount WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':limit_amount', $limitAmount);
            $updateStmt->bindParam(':id', $row['id']);
            return $updateStmt->execute();
        } else {
            // Insert
            $insertQuery = "INSERT INTO budgets (user_id, category, limit_amount, month) VALUES (:user_id, :category, :limit_amount, :month)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $userId);
            $insertStmt->bindParam(':category', $category);
            $insertStmt->bindParam(':limit_amount', $limitAmount);
            $insertStmt->bindParam(':month', $month);
            return $insertStmt->execute();
        }
    }

    public function getCategoryLimits($userId, $month = null) {
        if (!$month) $month = date('Y-m');
        $query = "SELECT category, limit_amount FROM budgets WHERE user_id = :user_id AND month = :month";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        
        $results = [];
        foreach($stmt->fetchAll() as $row) {
            $results[$row['category']] = $row['limit_amount'];
        }
        return $results;
    }
}
?>
