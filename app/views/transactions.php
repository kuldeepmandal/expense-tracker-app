<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; color: var(--text-primary);">
    <h2>Transactions - <?= date('F Y', strtotime($currentMonth . '-01')) ?></h2>
    <a href="index.php?page=dashboard" class="btn btn-outline" style="text-decoration: none; border: 1px solid var(--border-color);">&larr; Back to Dashboard</a>
</div>

<div class="card" style="background: var(--bg-card); border-radius: 12px; padding: 1.5rem; border: 1px solid var(--border-color);">
    <?php if (empty($transactions)): ?>
        <p class="text-muted" style="text-align: center; padding: 2rem 0;">No transactions recorded yet.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--bg-hover); color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; text-align: left;">
                    <th style="padding: 1rem 0.5rem;">Date</th>
                    <th style="padding: 1rem 0.5rem;">Title / Category</th>
                    <th style="padding: 1rem 0.5rem;">Payment Method</th>
                    <th style="padding: 1rem 0.5rem;">Type</th>
                    <th style="padding: 1rem 0.5rem; text-align: right;">Amount</th>
                    <th style="padding: 1rem 0.5rem; width: 40px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $tx): ?>
                <tr style="border-bottom: 1px solid var(--bg-hover);">
                    <td style="padding: 1rem 0.5rem; color: var(--text-secondary); font-size: 0.95rem;">
                        <?= date('d M Y', strtotime($tx['transaction_date'])) ?>
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        <strong style="color: var(--text-primary);"><?= htmlspecialchars($tx['description'] ?: $tx['category']) ?></strong>
                        <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">
                            <?= htmlspecialchars($tx['category']) ?>
                        </div>
                    </td>
                    <td style="padding: 1rem 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">
                        <?= !empty($tx['payment_method']) ? htmlspecialchars($tx['payment_method']) : '-' ?>
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        <?php if ($tx['type'] == 'income'): ?>
                            <span style="background: var(--color-green-light-bg); color: var(--color-green-dark); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">INCOME</span>
                        <?php else: ?>
                            <span style="background: var(--color-red-light); color: var(--color-red-dark); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">EXPENSE</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 1rem 0.5rem; text-align: right; font-weight: bold; font-size: 1.1rem; color: <?= $tx['type'] == 'expense' ? 'var(--color-red-dark)' : 'var(--color-green-dark)' ?>;">
                        <?= $tx['type'] == 'expense' ? '-' : '+' ?><?= $loggedInUser['currency_preference'] ?> <?= number_format($tx['amount']) ?>
                    </td>
                    <td style="padding: 1rem 0.5rem; text-align: right;">
                        <button type="button" onclick="confirmDelete(<?= $tx['id'] ?>)" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px; transition: color 0.2s;" onmouseover="this.style.color='var(--color-red-main)'" onmouseout="this.style.color='var(--text-muted)'" title="Delete Transaction">
                            <i class="ph ph-trash" style="font-size: 1.2rem;"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if ($totalPages > 1): ?>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
            <div style="font-size: 0.9rem; color: var(--text-secondary);">
                Showing page <?= $currentPage ?> of <?= $totalPages ?>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <?php if ($currentPage > 1): ?>
                    <a href="index.php?page=transactions&month=<?= urlencode($currentMonth) ?>&p=<?= $currentPage - 1 ?>" class="btn btn-outline" style="padding: 0.5rem 1rem; text-decoration: none; border: 1px solid var(--border-color); color: var(--text-secondary); border-radius: 6px;">Previous</a>
                <?php endif; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="index.php?page=transactions&month=<?= urlencode($currentMonth) ?>&p=<?= $currentPage + 1 ?>" class="btn btn-outline" style="padding: 0.5rem 1rem; text-decoration: none; border: 1px solid var(--border-color); color: var(--text-secondary); border-radius: 6px;">Next</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--bg-card); padding: 2rem; border-radius: 12px; width: 100%; max-width: 400px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-red-light); color: var(--color-red-dark); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
            <i class="ph ph-warning-circle" style="font-size: 1.8rem;"></i>
        </div>
        <h3 style="margin-bottom: 0.5rem; color: var(--text-primary); font-size: 1.25rem;">Delete Transaction</h3>
        <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.95rem; line-height: 1.5;">Are you sure you want to delete this transaction? This action cannot be undone and will affect your monthly reports.</p>
        
        <form method="POST" action="index.php?page=transactions<?= isset($_GET['month']) ? '&month=' . urlencode($_GET['month']) : '' ?><?= isset($_GET['p']) ? '&p=' . (int)$_GET['p'] : '' ?>">
            <input type="hidden" name="action" value="delete_transaction">
            <input type="hidden" name="transaction_id" id="deleteTxId" value="">
            <div style="display: flex; gap: 1rem;">
                <button type="button" onclick="closeDeleteModal()" class="btn btn-outline" style="flex: 1; justify-content: center; border: 1px solid var(--border-color);">Cancel</button>
                <button type="submit" class="btn" style="flex: 1; justify-content: center; background: var(--color-red-dark); color: white; border: none;">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete(id) {
    document.getElementById('deleteTxId').value = id;
    document.getElementById('deleteModal').style.display = 'flex';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
</script>

