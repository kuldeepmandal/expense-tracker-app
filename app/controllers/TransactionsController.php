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
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'delete_transaction') {
                $txId = $_POST['transaction_id'] ?? 0;
                if ($txId) {
                    $transactionModel->deleteTransaction($userId, $txId);
                }
                $monthParam = isset($_GET['month']) ? '&month=' . urlencode($_GET['month']) : '';
                $pParam = isset($_GET['p']) ? '&p=' . (int)$_GET['p'] : '';
                header("Location: index.php?page=transactions" . $monthParam . $pParam);
                exit;
            }
        }
        
        // Pagination logic
        $limit = 10;
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        $currentMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

        $totalTransactions = $transactionModel->getTotalCount($userId, $currentMonth);
        $totalPages = ceil($totalTransactions / $limit);

        $transactions = $transactionModel->getPaginated($userId, $limit, $offset, $currentMonth);
        
        $page = 'transactions';
        $view = 'app/views/transactions.php';
        require_once 'app/views/layout.php';
    }
}
?>
