<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div class="auth-split-layout">
    <div class="auth-left auth-left-centered">
        <button id="theme-toggle" class="btn btn-outline" style="position: absolute; top: 2rem; right: 2rem; padding: 0.5rem; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-primary); cursor: pointer; z-index: 100;">
            <i id="theme-icon" class="ph ph-moon" style="font-size: 20px;"></i>
        </button>
        
        <div style="margin-bottom: 2rem;">
            <a href="index.php?page=login" style="color: var(--text-secondary); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-secondary)'">&larr; Back to login</a>
        </div>

        <h1 style="font-size: 2rem; color: var(--text-primary); margin-bottom: 0.5rem; font-weight: 700;">Forgot Password?</h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 2.5rem; line-height: 1.5; max-width: 400px;">
            Enter your registered email address and we'll send you an OTP to reset your password.
        </p>

        <?php if (isset($error)): ?>
            <div style="background: var(--color-red-light); color: var(--color-red-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=forgot_password" style="max-width: 400px;">
            <div class="auth-form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="auth-input" required placeholder="name@example.com">
            </div>

            <button type="submit" class="auth-btn">Send OTP</button>
        </form>
    </div>

    <!-- Reusing the exact same right panel from login for consistency -->
    <div class="auth-right">
        <div class="auth-circle-bg" style="width: 400px; height: 400px; top: -100px; right: -100px;"></div>
        <div class="auth-circle-bg" style="width: 300px; height: 300px; bottom: 10%; left: -50px;"></div>

        <div class="auth-glass-widget">
            <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; margin-bottom: 0.5rem; text-transform: uppercase;">Current Balance</p>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <h3 style="font-size: 2.5rem; font-weight: 700; margin: 0;">₹42,850<span style="color: var(--color-green-light);">.00</span></h3>
            </div>
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <div class="auth-glass-card" style="flex: 1;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Expense Tracking</h4>
                    <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.5;">Log your daily transactions instantly and keep your budget in check.</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 3rem; width: 100%; max-width: 520px; border-left: 2px solid var(--color-green-dark); padding-left: 1.5rem; z-index: 10;">
            <p style="color: var(--bg-body); font-size: 1.1rem; font-style: italic; line-height: 1.6; margin-bottom: 1rem;">
                "Spendly makes managing my daily budget effortless. It's the cleanest and most intuitive finance tracker I've ever used."</p>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
                — Early Adopter</p>
        </div>
    </div>
</div>

