<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; color: var(--text-primary);">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <h2>Reports & Budgeting</h2>
        <form method="GET" action="index.php" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="hidden" name="page" value="reports">
            <input type="month" name="month" value="<?= htmlspecialchars($currentMonth) ?>" onchange="this.form.submit()" style="padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; font-weight: 500; font-family: inherit; background: var(--bg-input); color: var(--text-primary);">
        </form>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="index.php?page=reports&action=download&month=<?= urlencode($currentMonth) ?>" class="btn btn-outline" style="border: 1px solid var(--border-color); background: var(--bg-card); cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="ph ph-download-simple"></i> Download Full Report
        </a>
        <button onclick="openModal('categoryLimitModal')" class="btn btn-outline" style="border: 1px solid var(--border-color); background: var(--bg-card); cursor: pointer;">
            <i class="ph ph-sliders"></i> Set Category Limits
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
    <!-- Month Category Allocation -->
    <div class="card" style="background: var(--bg-card); border-radius: 12px; padding: 2rem; border: 1px solid var(--border-color); color: var(--text-primary);">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Month Category Allocation</h3>
        
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach($allocations as $alloc): ?>
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($alloc['category']) ?></span>
                        <?php if($alloc['isAlert']): ?>
                            <span style="background: var(--color-red-light); color: var(--color-red-main); padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: bold;">Warning</span>
                        <?php endif; ?>
                    </div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary);">
                        <span style="<?= $alloc['isAlert'] ? 'color: var(--color-red-main); font-weight: bold;' : '' ?>">
                            <?= $currency ?><?= number_format($alloc['spent']) ?>
                        </span>
                        / <?= $alloc['limit'] > 0 ? $currency . number_format($alloc['limit']) : 'No Limit' ?>
                    </div>
                </div>
                <!-- Progress Bar -->
                <div style="width: 100%; height: 8px; background: var(--bg-hover); border-radius: 4px; overflow: hidden;">
                    <?php 
                        $barColor = $alloc['isAlert'] ? 'var(--color-red-main)' : 'var(--color-green-dark)';
                        $barWidth = $alloc['limit'] > 0 ? $alloc['pct'] : 0;
                    ?>
                    <div style="height: 100%; width: <?= $barWidth ?>%; background: <?= $barColor ?>; border-radius: 4px; transition: width 0.3s ease;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Category Spend Pie Chart -->
    <div class="card" style="background: var(--bg-card); border-radius: 12px; padding: 2rem; border: 1px solid var(--border-color); color: var(--text-primary);">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Spending by Category</h3>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 1rem;">
            <div style="flex: 1; min-width: 80px;">
                <p style="font-size: 0.7rem; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 500;">Base Budget</p>
                <h4 style="font-size: 1.1rem; color: var(--text-primary); margin: 0; white-space: nowrap;"><?= $currency ?><?= number_format($baseBudget) ?></h4>
            </div>
            <div style="flex: 1; min-width: 80px;">
                <p style="font-size: 0.7rem; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 500;">Total Income</p>
                <h4 style="font-size: 1.1rem; color: var(--color-green-dark); margin: 0; white-space: nowrap;">+<?= $currency ?><?= number_format($totalIncome) ?></h4>
            </div>
            <div style="flex: 1; min-width: 80px;">
                <p style="font-size: 0.7rem; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 500;">Total Expense</p>
                <h4 style="font-size: 1.1rem; color: var(--color-red-main); margin: 0; white-space: nowrap;">-<?= $currency ?><?= number_format($totalSpent) ?></h4>
            </div>
            <div style="flex: 1; min-width: 80px;">
                <p style="font-size: 0.7rem; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 500;"><?= $statusValue >= 0 ? 'Remaining' : 'Overspent' ?></p>
                <h4 style="font-size: 1.1rem; color: <?= $statusValue >= 0 ? 'var(--text-primary)' : 'var(--color-red-main)' ?>; margin: 0; white-space: nowrap;"><?= $currency ?><?= number_format(abs($statusValue)) ?></h4>
            </div>
        </div>
        
        <?php 
            $hasData = false;
            foreach ($allocations as $a) {
                if ($a['spent'] > 0) $hasData = true;
            }
        ?>
        
        <?php if ($hasData): ?>
            <div style="position: relative; height: 300px; width: 100%; display: flex; justify-content: center;">
                <canvas id="categoryPieChart"></canvas>
            </div>
        <?php else: ?>
            <div style="height: 300px; display: flex; align-items: center; justify-content: center; color: #64748B;">
                No spending data for this month.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Styles from dashboard reused -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function openModal(id) { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }

<?php if ($hasData): ?>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('categoryPieChart').getContext('2d');
    const chartData = {
        labels: [<?= implode(',', array_map(function($a) { return "'" . addslashes($a['category']) . "'"; }, $allocations)) ?>],
        datasets: [{
            data: [<?= implode(',', array_map(function($a) { return $a['spent']; }, $allocations)) ?>],
            backgroundColor: [
                '#0B8A61', // Main Green
                '#59D893', // Light Green
                '#0F172A', // Dark Navy
                '#94A3B8', // Slate Light
                '#E12D39'  // Red
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    };

    new Chart(ctx, {
        type: 'pie',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim(),
                        font: { family: "'Inter', sans-serif", size: 12 },
                        padding: 15
                    }
                }
            }
        }
    });
});
<?php endif; ?>
</script>

<!-- Set Category Limit Modal -->
<div id="categoryLimitModal" class="modal-overlay">
    <div class="modal-content">
        <i class="ph ph-x modal-close" onclick="closeModal('categoryLimitModal')"></i>
        <h2 style="margin-bottom: 1.5rem;">Set Category Limit</h2>
        <p class="text-muted" style="margin-bottom: 1rem; font-size: 0.9rem;">Assign a monthly spending limit to a specific category.</p>
        <form method="POST" action="index.php?page=reports">
            <input type="hidden" name="action" value="set_category_limit">
            <input type="hidden" name="target_month" value="<?= htmlspecialchars($currentMonth) ?>">
            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <?php foreach($standardCategories as $cat): ?>
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Monthly Limit (<?= $currency ?>)</label>
                <input type="number" name="limit_amount" required min="1" oninvalid="this.setCustomValidity('Amount must be greater than 0')" oninput="this.setCustomValidity('')" placeholder="e.g. 5000">
            </div>
            <button type="submit" class="btn btn-income" style="width: 100%; justify-content: center;">Save Limit</button>
        </form>
    </div>
</div>
