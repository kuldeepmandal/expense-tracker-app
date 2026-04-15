<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/models/Transaction.php';
require_once 'app/models/User.php';
require_once 'app/models/Budget.php';

class ReportsController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $userModel = new User();
        $transactionModel = new Transaction();
        $budgetModel = new Budget();

        $currentMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'set_category_limit') {
                $category = $_POST['category'] ?? '';
                $limitAmount = $_POST['limit_amount'] ?? 0;
                $targetMonth = $_POST['target_month'] ?? date('Y-m');
                
                if ($category && $limitAmount >= 0) {
                    $budgetModel->setCategoryLimit($userId, $category, $limitAmount, $targetMonth);
                }
                header("Location: index.php?page=reports&month=" . urlencode($targetMonth));
                exit;
            }
        }

        $user = $userModel->getUser($userId);
        $currency = $user['currency_preference'];
        
        $expensesByCategory = $transactionModel->getExpensesByCategory($userId, $currentMonth);
        $categoryLimits = $budgetModel->getCategoryLimits($userId, $currentMonth);

        // Predefined standard categories
        $standardCategories = ['Food', 'Transport', 'Utilities', 'Shopping', 'Other'];
        
        // Prepare data for view
        $allocations = [];
        foreach ($standardCategories as $cat) {
            $spent = $expensesByCategory[$cat] ?? 0;
            $limit = $categoryLimits[$cat] ?? 0;
            $allocations[] = [
                'category' => $cat,
                'spent' => $spent,
                'limit' => $limit,
                'pct' => $limit > 0 ? min(100, round(($spent / $limit) * 100)) : 0,
                'isAlert' => $limit > 0 && $spent > ($limit * 0.9) // Alert if spent > 90%
            ];
        }

        $page = 'reports';
        $view = 'app/views/reports.php';
        require_once 'app/views/layout.php';
    }
}
?>
