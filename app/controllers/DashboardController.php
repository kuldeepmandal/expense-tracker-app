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

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        $userModel = new User();
        $budgetModel = new Budget();

        // Handle POST submissions logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'add_expense' || $action === 'add_income') {
                $type = $action === 'add_expense' ? 'expense' : 'income';
                $amount = $_POST['amount'] ?? 0;
                $category = $_POST['category'] ?? 'Uncategorized';
                $description = $_POST['description'] ?? '';
                $transactionModel->addTransaction($userId, $type, $amount, $category, $description);
            } elseif ($action === 'set_budget') {
                $baseBudget = $_POST['base_budget'] ?? 0;
                $budgetModel->setCategoryLimit($userId, 'Overall', $baseBudget);
            }
            
            // Redirect to avoid form resubmission
            header("Location: index.php?page=dashboard");
            exit;
        }

        // Fetch user info for budget and savings
        $user = $userModel->getUser($userId);
        
        // Fetch financial summary for current month
        $summary = $transactionModel->getCurrentMonthSummary($userId);
        $recentTransactions = $transactionModel->getRecent($userId, 4);

        // Fetch limits for CURRENT month. If no Overall budget was set this month, it defaults to 0
        $limits = $budgetModel->getCategoryLimits($userId);
        $baseBudget = $limits['Overall'] ?? 0;

        $totalSavings = $user['total_savings'];
        
        $totalIncome = $summary['income'] ?? 0;
        $totalSpent = $summary['expense'] ?? 0;

        // Total Pool = Base Budget + Income
        $totalBudgetPool = $baseBudget + $totalIncome;

        // Status Value = Budget Pool - Spent
        $statusValue = $totalBudgetPool - $totalSpent;
        $remaining = max(0, $statusValue);

        // Format recent transactions with icons
        $formattedRecent = [];
        foreach($recentTransactions as $tx) {
            $icon = 'ph-receipt';
            if ($tx['type'] == 'income') $icon = 'ph-briefcase';
            elseif ($tx['category'] == 'Groceries' || $tx['category'] == 'Food') $icon = 'ph-shopping-cart';
            elseif ($tx['category'] == 'Transport') $icon = 'ph-car';

            $formattedRecent[] = [
                'id' => $tx['id'],
                'title' => $tx['description'] ?: $tx['category'],
                'date' => date('d M Y', strtotime($tx['transaction_date'])),
                'category' => $tx['category'],
                'type' => $tx['type'],
                'amount' => $tx['amount'],
                'icon' => $icon
            ];
        }

        $data = [
            'base_budget' => $baseBudget,
            'total_savings' => $totalSavings,
            'budget_pool' => $totalBudgetPool,
            'spent' => $totalSpent,
            'remaining' => $remaining,
            'status_value' => $statusValue,
            'activities' => count($transactionModel->getAll($userId)),
            'recent' => $formattedRecent
        ];

        $page = 'dashboard';
        $view = 'app/views/dashboard.php';
        require_once 'app/views/layout.php';
    }
}
?>
