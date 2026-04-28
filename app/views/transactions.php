<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>All Transactions</h2>
    <a href="index.php?page=dashboard" class="btn btn-outline" style="text-decoration: none; color: inherit; border: 1px solid #E2E8F0;">&larr; Back to Dashboard</a>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #E2E8F0;">
    <?php if (empty($transactions)): ?>
        <p class="text-muted" style="text-align: center; padding: 2rem 0;">No transactions recorded yet.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #F1F5F9; color: #64748B; text-transform: uppercase; font-size: 0.8rem; text-align: left;">
                    <th style="padding: 1rem 0.5rem;">Date</th>
                    <th style="padding: 1rem 0.5rem;">Title / Category</th>
                    <th style="padding: 1rem 0.5rem;">Payment Method</th>
                    <th style="padding: 1rem 0.5rem;">Type</th>
                    <th style="padding: 1rem 0.5rem; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $tx): ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 1rem 0.5rem; color: #475569; font-size: 0.95rem;">
                        <?= date('d M Y', strtotime($tx['transaction_date'])) ?>
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        <strong><?= htmlspecialchars($tx['description'] ?: $tx['category']) ?></strong>
                        <div style="font-size: 0.8rem; color: #64748B; margin-top: 4px;">
                            <?= htmlspecialchars($tx['category']) ?>
                        </div>
                    </td>
                    <td style="padding: 1rem 0.5rem; color: #475569; font-size: 0.9rem;">
                        <?= !empty($tx['payment_method']) ? htmlspecialchars($tx['payment_method']) : '-' ?>
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        <?php if ($tx['type'] == 'income'): ?>
                            <span style="background: #E2FCEF; color: #0B8A61; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">INCOME</span>
                        <?php else: ?>
                            <span style="background: #FFEAEC; color: #D24153; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">EXPENSE</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 1rem 0.5rem; text-align: right; font-weight: bold; font-size: 1.1rem; color: <?= $tx['type'] == 'expense' ? '#D24153' : '#0B8A61' ?>;">
                        <?= $tx['type'] == 'expense' ? '-' : '+' ?><?= $loggedInUser['currency_preference'] ?> <?= number_format($tx['amount']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if ($totalPages > 1): ?>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #E2E8F0;">
            <div style="font-size: 0.9rem; color: #64748B;">
                Showing page <?= $currentPage ?> of <?= $totalPages ?>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <?php if ($currentPage > 1): ?>
                    <a href="index.php?page=transactions&p=<?= $currentPage - 1 ?>" class="btn btn-outline" style="padding: 0.5rem 1rem; text-decoration: none; border: 1px solid #E2E8F0; color: #475569; border-radius: 6px;">Previous</a>
                <?php endif; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="index.php?page=transactions&p=<?= $currentPage + 1 ?>" class="btn btn-outline" style="padding: 0.5rem 1rem; text-decoration: none; border: 1px solid #E2E8F0; color: #475569; border-radius: 6px;">Next</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
