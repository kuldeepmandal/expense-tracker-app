<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Krishna
 * @description UI View component.
 */
$loggedInUser = null;
if (isset($_SESSION['user_id'])) {
    require_once 'app/models/User.php';
    $userModel = new User();
    $loggedInUser = $userModel->getUser($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spendly</title>
    <link rel="icon" href="assets/images/Fabicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="public/css/style.css?v=<?= time() ?>">
</head>
<body>
    <?php if (in_array($page, ['login', 'register'])): ?>
        <?php require_once $view; ?>
    <?php else: ?>
    <div class="container">
        <!-- Navigation -->
        <?php if ($loggedInUser): ?>
        <nav class="navbar">
            <h2>Spendly</h2>
            
            <div class="nav-links">
                <a href="index.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">Home</a>
                <a href="index.php?page=transactions" class="<?= $page == 'transactions' ? 'active' : '' ?>">Transactions</a>
                <a href="index.php?page=reports" class="<?= $page == 'reports' ? 'active' : '' ?>">Reports</a>
                <a href="index.php?page=profile" class="<?= $page == 'profile' ? 'active' : '' ?>">Profile</a>
            </div>

            <div class="profile-section">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.9rem; font-weight: 500;"><?= htmlspecialchars(explode(' ', $loggedInUser['full_name'])[0]) ?></span>
                    <div class="profile-pic"><?= strtoupper(substr($loggedInUser['full_name'], 0, 1)) ?></div>
                </div>
                <a href="index.php?page=logout" style="text-decoration: none;">
                    <i class="ph ph-sign-out" style="font-size: 24px; color: var(--text-secondary); cursor: pointer;"></i>
                </a>
            </div>
        </nav>
        <?php else: ?>
        <nav class="navbar" style="justify-content: center;">
            <h2>Spendly</h2>
        </nav>
        <?php endif; ?>

        <!-- Dynamic View Content -->
        <main>
            <?php require_once $view; ?>
        </main>

    </div>
    <?php endif; ?>
    <script>
        // Force a reload if the page is loaded from the Back-Forward Cache (BFCache)
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M128,56C48,56,16,128,16,128s32,72,112,72,112-72,112-72S208,56,128,56Zm0,128C71.36,184,37.33,141.22,25.86,128,37.33,114.78,71.36,72,128,72s90.64,42.78,102.14,56C218.67,141.22,184.64,184,128,184ZM128,88a40,40,0,1,0,40,40A40,40,0,0,0,128,88Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,152Z"></path><line x1="48" y1="48" x2="208" y2="208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.48c.35.79,8.82,19.58,27.65,38.41C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.35c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>';
            }
        }
    </script>
</body>
</html>
