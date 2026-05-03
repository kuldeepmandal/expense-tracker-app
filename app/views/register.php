<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
?>
<div class="auth-split-layout">
    <div class="auth-left">
        <div class="auth-logo">
            <img src="assets/images/Logo.png" alt="Spendly Logo" style="height: 32px; width: auto;">
            Spendly
        </div>
        <p style="color: #64748B; font-size: 0.95rem;">Spend smartly. Track every rupee.</p>
        
        <div class="auth-pill-nav">
            <a href="index.php?page=register" class="active">Sign Up</a>
            <a href="index.php?page=login">Log In</a>
        </div>
        
        <h1 style="font-size: 2rem; color: #0F172A; margin-bottom: 0.5rem; font-weight: 700;">Create your account</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin-bottom: 2.5rem; line-height: 1.5; max-width: 400px;">
            Take control of your finances with powerful tracking and simple analytics.
        </p>
        
        <?php if(isset($error)): ?>
            <div style="background: #FFEAEC; color: #D24153; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register" style="max-width: 400px;">
            <div class="auth-form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" class="auth-input" required placeholder="Arjun Sharma">
            </div>

            <div class="auth-form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="auth-input" required placeholder="arjun@example.com">
            </div>
            
            <div class="auth-form-group">
                <label>Password</label>
                <div style="position: relative;">
                    <input type="password" id="registerPassword" name="password" class="auth-input" required placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility('registerPassword')" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748B; padding: 0;">
                        <svg id="registerPassword-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.48c.35.79,8.82,19.58,27.65,38.41C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.35c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="auth-form-group">
                <label>Confirm Password</label>
                <div style="position: relative;">
                    <input type="password" id="confirmPassword" name="confirm_password" class="auth-input" required placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="auth-btn">Create Account</button>
            
            <p style="text-align: center; margin-top: 2rem; font-size: 0.8rem; color: #64748B;">
                By signing up, you agree to our <a href="#" style="color: #0B8A61; font-weight: 600;">Terms</a> and <a href="#" style="color: #0B8A61; font-weight: 600;">Privacy Policy</a>.
            </p>
        </form>
    </div>
    
    <div class="auth-right">
        <div class="auth-circle-bg" style="width: 400px; height: 400px; top: -100px; right: -100px;"></div>
        <div class="auth-circle-bg" style="width: 300px; height: 300px; bottom: 10%; left: -50px;"></div>
        
        <div class="auth-glass-widget">
            <p style="font-size: 0.75rem; color: #94A3B8; font-weight: 600; letter-spacing: 1px; margin-bottom: 0.5rem; text-transform: uppercase;">Current Balance</p>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <h3 style="font-size: 2.5rem; font-weight: 700; margin: 0;">₹42,850<span style="color: #59D893;">.00</span></h3>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <div class="auth-glass-card" style="flex: 1;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Expense Tracking</h4>
                    <p style="font-size: 0.8rem; color: #94A3B8; line-height: 1.5;">Log your daily transactions instantly and keep your budget in check.</p>
                </div>
                <div class="auth-glass-card" style="flex: 1;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Visual Analytics</h4>
                    <p style="font-size: 0.8rem; color: #94A3B8; line-height: 1.5;">Understand your spending patterns with beautiful, easy-to-read charts.</p>
                </div>
            </div>
            
            <div class="auth-glass-card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-radius: 50px;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div>
                        <h5 style="margin: 0; font-size: 0.95rem;">Grocery Shopping</h5>
                        <p style="margin: 0; font-size: 0.75rem; color: #94A3B8;">Supermarket</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <h5 style="margin: 0; font-size: 0.95rem; color: #E12D39;">-₹2,140</h5>
                    <p style="margin: 0; font-size: 0.65rem; color: #94A3B8; text-transform: uppercase; font-weight: bold;">Cash Payment</p>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 3rem; width: 100%; max-width: 520px; border-left: 2px solid #0B8A61; padding-left: 1.5rem; z-index: 10;">
            <p style="color: #F8FAFC; font-size: 1.1rem; font-style: italic; line-height: 1.6; margin-bottom: 1rem;">"Spendly makes managing my daily budget effortless. It's the cleanest and most intuitive finance tracker I've ever used."</p>
            <p style="color: #94A3B8; font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">— Early Adopter</p>
        </div>
    </div>
</div>
