<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
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
            <div style="position: relative;">
                <input type="password" id="loginPassword" name="password" required style="width: 100%; padding: 0.75rem; padding-right: 2.5rem; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="••••••••">
                <button type="button" onclick="togglePasswordVisibility('loginPassword')" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748B; padding: 0;">
                    <svg id="loginPassword-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.48c.35.79,8.82,19.58,27.65,38.41C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.35c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-expense" style="width: 100%; justify-content: center; background-color: var(--color-green-dark); margin-top: 1rem;">Login</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">
        Don't have an account? <a href="index.php?page=register" style="color: var(--color-green-dark); font-weight: 600;">Sign up</a>
    </p>
</div>
