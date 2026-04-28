<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <h2>Reports & Budgeting</h2>
        <form method="GET" action="index.php" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="hidden" name="page" value="reports">
            <input type="month" name="month" value="<?= htmlspecialchars($currentMonth) ?>" onchange="this.form.submit()" style="padding: 0.5rem; border: 1px solid #E2E8F0; border-radius: 8px; font-weight: 500; font-family: inherit;">
        </form>
    </div>
    <button onclick="openModal('categoryLimitModal')" class="btn btn-outline" style="border: 1px solid #E2E8F0; background: white; cursor: pointer;">
        <i class="ph ph-sliders"></i> Set Category Limits
    </button>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
    <!-- Month Category Allocation -->
    <div class="card" style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #E2E8F0;">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Month Category Allocation</h3>
        
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach($allocations as $alloc): ?>
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($alloc['category']) ?></span>
                        <?php if($alloc['isAlert']): ?>
                            <span style="background: #FFEAEC; color: #D24153; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: bold;">Warning</span>
                        <?php endif; ?>
                    </div>
                    <div style="font-size: 0.85rem; color: #64748B;">
                        <span style="<?= $alloc['isAlert'] ? 'color: #D24153; font-weight: bold;' : '' ?>">
                            <?= $currency ?><?= number_format($alloc['spent']) ?>
                        </span>
                        / <?= $alloc['limit'] > 0 ? $currency . number_format($alloc['limit']) : 'No Limit' ?>
                    </div>
                </div>
                <!-- Progress Bar -->
                <div style="width: 100%; height: 8px; background: #F1F5F9; border-radius: 4px; overflow: hidden;">
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

<script>
function openModal(id) { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }
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
