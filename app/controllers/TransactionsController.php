<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/models/Transaction.php';

/**
 * Class TransactionsController
 * Manages the display and logic for user transactions overview.
 */
class TransactionsController {
    /**
     * Displays the transactions page.
     * Redirects to login if user is not authenticated.
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        
        // Pagination logic
        $limit = 10;
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        $totalTransactions = $transactionModel->getTotalCount($userId);
        $totalPages = ceil($totalTransactions / $limit);

        $transactions = $transactionModel->getPaginated($userId, $limit, $offset);
        
        $page = 'transactions';
        $view = 'app/views/transactions.php';
        require_once 'app/views/layout.php';
    }
}
?>
