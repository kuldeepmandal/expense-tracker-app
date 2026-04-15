<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div style="max-width: 400px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <h2 style="text-align: center; margin-bottom: 1.5rem;">Create Account</h2>
    
    <?php if(isset($error)): ?>
        <div style="background: #FFEAEC; color: #D24153; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=register" style="display: flex; flex-direction: column; gap: 1rem;">
        <div>
            <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Full Name</label>
            <input type="text" name="full_name" required style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="John Doe">
        </div>
        <div>
            <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="name@example.com">
        </div>
        <div>
            <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Password</label>
            <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-expense" style="width: 100%; justify-content: center; background-color: var(--color-green-dark); margin-top: 1rem;">Sign Up</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">
        Already have an account? <a href="index.php?page=login" style="color: var(--color-green-dark); font-weight: 600;">Log in</a>
    </p>
</div>
