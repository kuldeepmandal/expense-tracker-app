<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Profile Settings</h2>
</div>

<?php if(!empty($message)): ?>
    <div style="background: #E2FCEF; color: #0B8A61; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if(!empty($error)): ?>
    <div style="background: #FFEAEC; color: #D24153; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    
    <!-- Personal Information Card -->
    <div class="card" style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #E2E8F0;">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Personal Information</h3>
        <form method="POST" action="index.php?page=profile" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="hidden" name="action" value="update_profile">
            <div>
                <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Full Name</label>
                <input type="text" name="full_name" required value="<?= htmlspecialchars($user['full_name']) ?>" style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;">
            </div>
            <div>
                <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Email Address</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>" style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;">
            </div>
            <button type="submit" class="btn btn-income" style="width: 100%; justify-content: center; margin-top: 0.5rem;">Update Info</button>
        </form>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Security Card -->
        <div class="card" style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #E2E8F0;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Security</h3>
            <form method="POST" action="index.php?page=profile" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="hidden" name="action" value="update_security">
                <div>
                    <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">New Password</label>
                    <input type="password" name="new_password" required minlength="6" placeholder="Enter new password" style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;">
                </div>
                <button type="submit" class="btn btn-expense" style="width: 100%; justify-content: center; background-color: var(--color-green-dark); margin-top: 0.5rem;">Change Password</button>
            </form>
        </div>

        <!-- Preferences Card -->
        <div class="card" style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #E2E8F0;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Preferences</h3>
            <form method="POST" action="index.php?page=profile" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="hidden" name="action" value="update_preferences">
                <div>
                    <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Currency Symbol</label>
                    <select name="currency_preference" required style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;">
                        <option value="Rs." <?= $user['currency_preference'] == 'Rs.' ? 'selected' : '' ?>>Nepalese Rupee / Indian Rupee (Rs.)</option>
                        <option value="$" <?= $user['currency_preference'] == '$' ? 'selected' : '' ?>>US Dollar ($)</option>
                        <option value="€" <?= $user['currency_preference'] == '€' ? 'selected' : '' ?>>Euro (€)</option>
                        <option value="£" <?= $user['currency_preference'] == '£' ? 'selected' : '' ?>>British Pound (£)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline" style="width: 100%; justify-content: center; margin-top: 0.5rem; border: 1px solid #CBD5E1;">Save Preferences</button>
            </form>
        </div>
    </div>
</div>
