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

        <h1 style="font-size: 2rem; color: var(--text-primary); margin-bottom: 0.5rem; font-weight: 700;">Reset Password</h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 2.5rem; line-height: 1.5; max-width: 400px;">
            We've sent a 6-digit OTP to <strong><?= htmlspecialchars($_SESSION['reset_email'] ?? 'your email') ?></strong>. Please enter it below along with your new password.
        </p>

        <?php if (isset($error)): ?>
            <div style="background: var(--color-red-light); color: var(--color-red-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div style="background: var(--color-green-light-bg); color: var(--color-green-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <?= htmlspecialchars($success) ?>
                <br><br><a href="index.php?page=login" style="color: var(--color-green-dark); font-weight: bold; text-decoration: underline;">Click here to log in</a>
            </div>
        <?php else: ?>
            <form method="POST" action="index.php?page=reset_password" style="max-width: 400px;">
                <div class="auth-form-group">
                    <label>6-Digit OTP</label>
                    <input type="text" name="otp" class="auth-input" required placeholder="123456" maxlength="6" style="text-align: center; letter-spacing: 4px; font-weight: bold; font-size: 1.2rem;">
                </div>

                <div class="auth-form-group">
                    <label>New Password</label>
                    <div style="position: relative;">
                        <input type="password" id="resetPassword" name="password" class="auth-input" required placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility('resetPassword')" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-secondary); padding: 0;">
                            <svg id="resetPassword-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.48c.35.79,8.82,19.58,27.65,38.41C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.35c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="auth-form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="auth-input" required placeholder="••••••••">
                </div>

                <button type="submit" class="auth-btn">Reset Password</button>
            </form>
        <?php endif; ?>
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

