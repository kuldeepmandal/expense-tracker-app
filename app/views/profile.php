<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; color: var(--text-primary);">
    <h2>Profile Settings</h2>
</div>

<?php if(!empty($message)): ?>
    <div style="background: var(--color-green-light-bg); color: var(--color-green-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if(!empty($error)): ?>
    <div style="background: var(--color-red-light); color: var(--color-red-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    
    <!-- Personal Information Card -->
    <div class="card" style="background: var(--bg-card); border-radius: 12px; padding: 2rem; border: 1px solid var(--border-color); color: var(--text-primary);">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Personal Information</h3>
        <?php if (isset($_SESSION['pending_email'])): ?>
            <div style="background: var(--color-warning-light); border: 1px solid var(--color-warning-border); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                <h4 style="color: var(--color-warning); margin-bottom: 0.5rem;">Verify Email Change</h4>
                <p style="font-size: 0.9rem; color: var(--color-warning); margin-bottom: 1rem; opacity: 0.9;">
                    We sent a 6-digit OTP to <strong><?= htmlspecialchars($_SESSION['pending_email']) ?></strong>. Enter it below to confirm.
                </p>
                <form method="POST" action="index.php?page=profile" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                    <input type="hidden" name="action" value="verify_email_change">
                    <input type="text" name="otp" required placeholder="123456" maxlength="6" style="flex: 1; padding: 0.75rem; border: 1px solid var(--color-warning-border); border-radius: 8px; text-align: center; letter-spacing: 2px; font-weight: bold; background: var(--bg-input); color: var(--text-primary);">
                    <button type="submit" class="btn btn-income" style="background-color: var(--color-warning);">Verify</button>
                </form>
                <form method="POST" action="index.php?page=profile">
                    <input type="hidden" name="action" value="cancel_email_change">
                    <button type="submit" style="background: none; border: none; color: var(--text-secondary); text-decoration: underline; cursor: pointer; font-size: 0.85rem; padding: 0;">Cancel change</button>
                </form>
            </div>
        <?php else: ?>
            <form method="POST" action="index.php?page=profile" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="hidden" name="action" value="update_profile">
                <div>
                    <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block; color: var(--text-primary);">Full Name</label>
                    <input type="text" name="full_name" required value="<?= htmlspecialchars($user['full_name']) ?>" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-input); color: var(--text-primary);">
                </div>
                <div>
                    <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block; color: var(--text-primary);">Email Address</label>
                    <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-input); color: var(--text-primary);">
                </div>
                <button type="submit" class="btn btn-income" style="width: 100%; justify-content: center; margin-top: 0.5rem;">Update Info</button>
            </form>
        <?php endif; ?>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Security Card -->
        <div class="card" style="background: var(--bg-card); border-radius: 12px; padding: 2rem; border: 1px solid var(--border-color); color: var(--text-primary);">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Security</h3>
            <form method="POST" action="index.php?page=profile" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="hidden" name="action" value="update_security">
                <div>
                    <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block; color: var(--text-primary);">New Password</label>
                    <div style="position: relative;">
                        <input type="password" id="profilePassword" name="new_password" required minlength="6" placeholder="Enter new password" style="width: 100%; padding: 0.75rem; padding-right: 2.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-input); color: var(--text-primary);">
                        <button type="button" onclick="togglePasswordVisibility('profilePassword')" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-secondary); padding: 0;">
                            <svg id="profilePassword-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.48c.35.79,8.82,19.58,27.65,38.41C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.35c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-expense" style="width: 100%; justify-content: center; background-color: var(--color-green-dark); margin-top: 0.5rem;">Change Password</button>
            </form>
        </div>

        <!-- Preferences Card -->
        <div class="card" style="background: var(--bg-card); border-radius: 12px; padding: 2rem; border: 1px solid var(--border-color); color: var(--text-primary);">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Preferences</h3>
            <form method="POST" action="index.php?page=profile" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="hidden" name="action" value="update_preferences">
                <div>
                    <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block; color: var(--text-primary);">Currency Symbol</label>
                    <select name="currency_preference" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-input); color: var(--text-primary);">
                        <option value="Rs." <?= $user['currency_preference'] == 'Rs.' ? 'selected' : '' ?>>Nepalese Rupee / Indian Rupee (Rs.)</option>
                        <option value="$" <?= $user['currency_preference'] == '$' ? 'selected' : '' ?>>US Dollar ($)</option>
                        <option value="€" <?= $user['currency_preference'] == '€' ? 'selected' : '' ?>>Euro (€)</option>
                        <option value="£" <?= $user['currency_preference'] == '£' ? 'selected' : '' ?>>British Pound (£)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline" style="width: 100%; justify-content: center; margin-top: 0.5rem; border: 1px solid var(--border-color);">Save Preferences</button>
            </form>
        </div>
    </div>
</div>

