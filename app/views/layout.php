<?php
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
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
</body>
</html>
