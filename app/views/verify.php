<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: var(--bg-body);">
    <div class="card" style="width: 100%; max-width: 400px; padding: 2rem; background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border-color);">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="color: var(--color-green-dark); font-size: 2rem; margin-bottom: 0.5rem;"><i class="ph ph-envelope-open"></i> Spendly</h1>
            <h2 style="font-size: 1.5rem; color: #1E293B;">Verify Your Email</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.5rem;">We've sent a 6-digit code to your email. It will expire in 15 minutes.</p>
        </div>

        <?php if(!empty($error)): ?>
            <div style="background: var(--color-red-light); color: var(--color-red-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=verify">
            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? ($_POST['email'] ?? '')) ?>">
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; color: #1E293B;">6-Digit OTP Code</label>
                <input type="text" name="code" required maxlength="6" pattern="\d{6}" placeholder="000000" style="width: 100%; padding: 0.75rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1.2rem; text-align: center; letter-spacing: 4px;">
            </div>

            <button type="submit" class="btn btn-income" style="width: 100%; justify-content: center; height: 48px; background-color: var(--color-green-dark);">Verify & Login</button>
        </form>
    </div>
</div>

