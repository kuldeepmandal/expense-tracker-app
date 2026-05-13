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

/**
 * Class ReportsController
 * Handles the display of financial reports and budget limit management.
 */
class ReportsController {
    /**
     * Displays the reports view including expenses by category and budget allocations.
     * Redirects to login if the user is not authenticated.
     */
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
        
        if (isset($_GET['action']) && $_GET['action'] === 'download') {
            $this->downloadReport($userId, $currentMonth, $currency, $transactionModel, $budgetModel);
            exit;
        }
        
        $expensesByCategory = $transactionModel->getExpensesByCategory($userId, $currentMonth);
        $categoryLimits = $budgetModel->getCategoryLimits($userId, $currentMonth);

        // Predefined standard categories
        $standardCategories = ['Food', 'Transport', 'Utilities', 'Shopping', 'Other'];
        
        // Prepare data for view
        $summary = $transactionModel->getCurrentMonthSummary($userId, $currentMonth);
        $totalIncome = $summary['income'] ?? 0;
        $totalSpent = $summary['expense'] ?? 0;
        $baseBudget = $categoryLimits['Overall'] ?? 0;
        $statusValue = ($baseBudget + $totalIncome) - $totalSpent;
        
        $allocations = [];
        foreach ($standardCategories as $cat) {
            $spent = $expensesByCategory[$cat] ?? 0;
            $limit = $categoryLimits[$cat] ?? 2000;
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

    /**
     * Generates and downloads a CSV report for the given month.
     */
    private function downloadReport($userId, $month, $currency, $transactionModel, $budgetModel) {
        $summary = $transactionModel->getCurrentMonthSummary($userId, $month);
        $totalIncome = $summary['income'] ?? 0;
        $totalSpent = $summary['expense'] ?? 0;
        
        $categoryLimits = $budgetModel->getCategoryLimits($userId, $month);
        $baseBudget = $categoryLimits['Overall'] ?? 0;
        
        $statusValue = ($baseBudget + $totalIncome) - $totalSpent;
        $statusLabel = $statusValue >= 0 ? "Saved/Remaining" : "Overspent";
        $statusAmount = abs($statusValue);
        
        $transactions = $transactionModel->getAll($userId, $month);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=spendly_report_' . $month . '.csv');

        $output = fopen('php://output', 'w');
        
        // Add title and summary
        fputcsv($output, ['Spendly Monthly Report', $month]);
        fputcsv($output, []);
        fputcsv($output, ['--- SUMMARY ---']);
        fputcsv($output, ["Base Budget ($currency)", $baseBudget]);
        fputcsv($output, ["Total Income ($currency)", $totalIncome]);
        fputcsv($output, ["Total Expense ($currency)", $totalSpent]);
        fputcsv($output, ["$statusLabel ($currency)", $statusAmount]);
        fputcsv($output, []);
        
        // Add transactions header
        fputcsv($output, ['--- TRANSACTIONS ---']);
        fputcsv($output, ['Date', 'Title / Category', 'Payment Method', 'Type', "Amount ($currency)"]);
        
        foreach ($transactions as $tx) {
            $title = $tx['description'] ? $tx['description'] . " (" . $tx['category'] . ")" : $tx['category'];
            fputcsv($output, [
                date('Y-m-d', strtotime($tx['transaction_date'])),
                $title,
                $tx['payment_method'] ?? 'N/A',
                strtoupper($tx['type']),
                $tx['amount']
            ]);
        }

        fclose($output);
    }
}
?>
