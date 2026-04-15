<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<header style="margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; display: flex; align-items: center; gap: 0.5rem;">
        Good morning, <?= htmlspecialchars(explode(' ', $loggedInUser['full_name'])[0]) ?> <span style="font-size: 1.5rem;">👋</span>
    </h1>
    <p class="text-muted" style="margin-top: 0.5rem;">Your financial narrative is looking healthy today.</p>
</header>

<!-- Summary Cards Row -->
<div class="dashboard-metrics" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
    <div class="metric-card" style="background-color: #F8F9FB; border: 1px solid #E2E8F0; padding: 1.5rem; border-radius: 16px;">
        <div style="display: flex; justify-content: space-between;">
            <p class="text-muted" style="text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: bold;">Budget Pool</p>
            <button onclick="openModal('budgetModal')" style="background: none; border: none; cursor: pointer; color: var(--color-green-dark);"><i class="ph ph-pencil-simple"></i>Edit</button>
        </div>
        <h2 style="font-size: 1.8rem;"><?= $loggedInUser['currency_preference'] ?> <?= number_format($data['budget_pool']) ?></h2>
        <p class="text-muted" style="font-size: 0.8rem; margin-top: 0.5rem;">Base: <?= $loggedInUser['currency_preference'] ?> <?= number_format($data['base_budget']) ?></p>
    </div>
    
    <div class="metric-card" style="background-color: #FFEAEC; border: none; padding: 1.5rem; border-radius: 16px;">
        <p style="color: #D24153; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: bold;">Total Spent</p>
        <h2 style="font-size: 1.8rem; color: #B31E2A;"><?= $loggedInUser['currency_preference'] ?> <?= number_format($data['spent']) ?></h2>
        <?php $pct = $data['budget_pool'] > 0 ? round(($data['spent'] / $data['budget_pool']) * 100) : 0; ?>
        <p style="color: #D24153; font-size: 0.8rem; margin-top: 0.5rem;"><?= $pct ?>% of current pool</p>
    </div>

    <div class="metric-card" style="background-color: #E2FCEF; border: none; padding: 1.5rem; border-radius: 16px;">
        <p style="color: #0B8A61; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: bold;">Remaining</p>
        <h2 style="font-size: 1.8rem; color: #086345;"><?= $loggedInUser['currency_preference'] ?> <?= number_format($data['remaining']) ?></h2>
        <p style="color: #0B8A61; font-size: 0.8rem; margin-top: 0.5rem;">Available to spend</p>
    </div>

    <?php if ($data['status_value'] >= 0): ?>
    <div class="metric-card" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; padding: 1.5rem; border-radius: 16px;">
        <p style="color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: bold;">Saved This Month</p>
        <h2 style="font-size: 1.8rem; color: #334155;"><?= $loggedInUser['currency_preference'] ?> <?= number_format($data['status_value']) ?></h2>
    </div>
    <?php else: ?>
    <div class="metric-card" style="background-color: #FFEAEC; border: 1px solid #D24153; padding: 1.5rem; border-radius: 16px;">
        <p style="color: #B31E2A; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: bold;"><i class="ph ph-warning"></i> Overspent Month</p>
        <h2 style="font-size: 1.8rem; color: #B31E2A;">- <?= $loggedInUser['currency_preference'] ?> <?= number_format(abs($data['status_value'])) ?></h2>
    </div>
    <?php endif; ?>
</div>

<!-- Actions Row -->
<div style="display: flex; gap: 1rem; margin-bottom: 3rem;">
    <button class="btn btn-expense" onclick="openModal('expenseModal')">
        <i class="ph ph-minus-circle" style="font-size: 18px;"></i> Add Expense
    </button>
    <button class="btn btn-income" onclick="openModal('incomeModal')">
        <i class="ph ph-plus-circle" style="font-size: 18px;"></i> Add Income
    </button>

    <a href="index.php?page=reports" class="btn btn-outline" style="background-color: #F1F5F9; border: none; text-decoration: none; color: inherit;">
        <i class="ph ph-file-text" style="font-size: 18px;"></i> View Reports
    </a>
</div>

<!-- Main Content Split -->
<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
    
    <!-- Left Col: Transactions -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Recent Transactions</h3>
            <a href="index.php?page=transactions" style="color: var(--color-green-dark); font-weight: 600; font-size: 0.9rem;">See All</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php if (empty($data['recent'])): ?>
                <p class="text-muted">No transactions found.</p>
            <?php else: ?>
                <?php foreach($data['recent'] as $trx): ?>
                <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-radius: 12px;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="background: #F1F5F9; padding: 10px; border-radius: 8px; font-size: 1.2rem; display:flex; align-items:center;">
                            <i class="ph <?= $trx['icon'] ?>"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 1rem; margin-bottom: 4px;"><?= htmlspecialchars($trx['title']) ?></h4>
                            <p class="text-muted"><?= htmlspecialchars($trx['date']) ?> • <?= htmlspecialchars($trx['category']) ?></p>
                        </div>
                    </div>
                    <div style="font-weight: bold; font-size: 1.1rem; color: <?= $trx['type'] === 'expense' ? 'var(--color-red-main)' : 'var(--color-green-dark)' ?>;">
                        <?= $trx['type'] === 'expense' ? '-' : '+' ?> <?= $loggedInUser['currency_preference'] ?> <?= number_format($trx['amount']) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Col: Charts -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <div class="card" style="background-color: #F8F9FB; border: 1px solid #E2E8F0; padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Expense Breakdown</h3>
            <div style="width: 180px; height: 180px; border-radius: 50%; background: conic-gradient(var(--color-red-main) 0% <?= $pct ?>%, #E2E8F0 <?= $pct ?>% 100%); margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                <div style="width: 120px; height: 120px; background-color: #F8F9FB; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <span style="font-size: 1.5rem; font-weight: bold;"><?= $pct ?>%</span>
                    <span class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; font-weight: bold;">Spent</span>
                </div>
            </div>
            <p class="text-muted" style="text-align: center; margin-top: 1rem; font-size: 0.85rem;">This represents total spent out of current available pool.</p>
        </div>
    </div>
</div>

<!-- MODALS -->

<!-- Modal Styles -->
<style>
.modal-overlay {
    display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;
}
.modal-content {
    background: white; padding: 2rem; border-radius: 12px; width: 100%; max-width: 400px;
    position: relative;
}
.modal-close {
    position: absolute; top: 1rem; right: 1rem; cursor: pointer; font-size: 1.5rem; color: #64748b;
}
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }
.form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px; }
</style>

<script>
function openModal(id) { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }
</script>

<!-- Add Expense Modal -->
<div id="expenseModal" class="modal-overlay">
    <div class="modal-content">
        <i class="ph ph-x modal-close" onclick="closeModal('expenseModal')"></i>
        <h2 style="margin-bottom: 1.5rem;">Add Expense</h2>
        <form method="POST" action="index.php?page=dashboard">
            <input type="hidden" name="action" value="add_expense">
            <div class="form-group">
                <label>Amount (<?= $loggedInUser['currency_preference'] ?>)</label>
                <input type="number" name="amount" required min="1">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <option value="Food">Food</option>
                    <option value="Transport">Transport</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description (Optional)</label>
                <input type="text" name="description" placeholder="e.g. Lunch at Cafe">
            </div>
            <button type="submit" class="btn btn-expense" style="width: 100%; justify-content: center;">Record Expense</button>
        </form>
    </div>
</div>

<!-- Add Income Modal -->
<div id="incomeModal" class="modal-overlay">
    <div class="modal-content">
        <i class="ph ph-x modal-close" onclick="closeModal('incomeModal')"></i>
        <h2 style="margin-bottom: 1.5rem;">Add Income</h2>
        <form method="POST" action="index.php?page=dashboard">
            <input type="hidden" name="action" value="add_income">
            <div class="form-group">
                <label>Amount (<?= $loggedInUser['currency_preference'] ?>)</label>
                <input type="number" name="amount" required min="1">
            </div>
            <div class="form-group">
                <label>Source / Category</label>
                <select name="category" required>
                    <option value="Salary">Salary</option>
                    <option value="Freelance">Freelance</option>
                    <option value="Investment">Investment</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description (Optional)</label>
                <input type="text" name="description" placeholder="e.g. Freelance project">
            </div>
            <button type="submit" class="btn btn-income" style="width: 100%; justify-content: center;">Record Income</button>
        </form>
    </div>
</div>

<!-- Set Budget Modal -->
<div id="budgetModal" class="modal-overlay">
    <div class="modal-content">
        <i class="ph ph-x modal-close" onclick="closeModal('budgetModal')"></i>
        <h2 style="margin-bottom: 1.5rem;">Set Base Budget</h2>
        <p class="text-muted" style="margin-bottom: 1rem; font-size: 0.9rem;">Set your fixed base monthly budget. Adding income will increase your total budget pool.</p>
        <form method="POST" action="index.php?page=dashboard">
            <input type="hidden" name="action" value="set_budget">
            <div class="form-group">
                <label>Base Budget Limit (<?= $loggedInUser['currency_preference'] ?>)</label>
                <input type="number" name="base_budget" required min="0" value="<?= $data['base_budget'] ?>">
            </div>
            <button type="submit" class="btn btn-income" style="width: 100%; justify-content: center;">Save Budget</button>
        </form>
    </div>
</div>


