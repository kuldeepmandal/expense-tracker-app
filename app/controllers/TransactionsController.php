<?php
require_once 'app/models/Transaction.php';

class TransactionsController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        
        $transactions = $transactionModel->getAll($userId);
        
        $page = 'transactions';
        $view = 'app/views/transactions.php';
        require_once 'app/views/layout.php';
    }
}
?>
