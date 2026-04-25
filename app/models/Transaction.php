<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/config/database.php';

/**
 * Class Transaction
 * Handles database operations related to user transactions.
 */
class Transaction {
    private $conn;

    /**
     * Initializes a new Transaction model instance and establishes a database connection.
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Records a new transaction (income or expense).
     *
     * @param int $userId The ID of the user.
     * @param string $type The type of transaction ('income' or 'expense').
     * @param float $amount The transaction amount.
     * @param string $category The category of the transaction.
     * @param string $description An optional description for the transaction.
     * @return bool Returns true on success, false on failure.
     */
    public function addTransaction($userId, $type, $amount, $category, $description, $paymentMethod = null) {
        $query = "INSERT INTO transactions (user_id, type, amount, category, payment_method, description, transaction_date) 
                  VALUES (:user_id, :type, :amount, :category, :payment_method, :description, CURDATE())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }

    /**
     * Retrieves the most recent transactions for a user.
     *
     * @param int $userId The ID of the user.
     * @param int $limit The maximum number of transactions to retrieve (default is 4).
     * @return array An array of recent transaction records.
     */
    public function getRecent($userId, $limit = 4) {
        $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_date DESC, id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves all transactions for a user ordered by date descending.
     *
     * @param int $userId The ID of the user.
     * @return array An array of all transaction records.
     */
    public function getAll($userId) {
        $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_date DESC, id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves paginated transactions for a user.
     *
     * @param int $userId The ID of the user.
     * @param int $limit The number of records to retrieve.
     * @param int $offset The offset for the records.
     * @return array An array of transaction records.
     */
    public function getPaginated($userId, $limit, $offset) {
        $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_date DESC, id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves the total count of transactions for a user.
     *
     * @param int $userId The ID of the user.
     * @return int The total number of transactions.
     */
    public function getTotalCount($userId) {
        $query = "SELECT COUNT(*) FROM transactions WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Calculates the total income and total expense for a specific month.
     *
     * @param int $userId The ID of the user.
     * @param string|null $month The month in 'YYYY-MM' format (defaults to current month).
     * @return array An associative array containing 'income' and 'expense' totals.
     */
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
    /**
     * Retrieves the total expenses grouped by category for a specific month.
     *
     * @param int $userId The ID of the user.
     * @param string|null $month The month in 'YYYY-MM' format (defaults to current month).
     * @return array An associative array mapping category names to their respective total expenses.
     */
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
