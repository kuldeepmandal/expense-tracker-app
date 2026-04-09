<div style="max-width: 400px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <h2 style="text-align: center; margin-bottom: 1.5rem;">Welcome Back</h2>
    
    <?php if(isset($error)): ?>
        <div style="background: #FFEAEC; color: #D24153; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login" style="display: flex; flex-direction: column; gap: 1rem;">
        <div>
            <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="name@example.com">
        </div>
        <div>
            <label style="font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">Password</label>
            <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-expense" style="width: 100%; justify-content: center; background-color: var(--color-green-dark); margin-top: 1rem;">Login</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">
        Don't have an account? <a href="index.php?page=register" style="color: var(--color-green-dark); font-weight: 600;">Sign up</a>
    </p>
</div>
