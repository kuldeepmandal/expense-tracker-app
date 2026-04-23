<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/config/database.php';

/**
 * Class Budget
 * Handles database operations for user budget limits and categories.
 */
class Budget {
    private $conn;

    /**
     * Initializes a new Budget model instance and establishes a database connection.
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Sets or updates the budget limit for a specific category and month.
     *
     * @param int $userId The ID of the user.
     * @param string $category The target category.
     * @param float $limitAmount The budget limit amount.
     * @param string|null $month The month in 'YYYY-MM' format. Defaults to current month.
     * @return bool Returns true on success, false on failure.
     */
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

    /**
     * Retrieves the budget limits for all categories for a given month.
     *
     * @param int $userId The ID of the user.
     * @param string|null $month The month in 'YYYY-MM' format. Defaults to current month.
     * @return array An associative array mapping category names to their budget limit.
     */
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
