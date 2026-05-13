<?php
// Root router
session_start();

// Prevent browser caching so 'back' button requires a re-fetch (and thus hits the auth guard)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Public routes
if ($page === 'login' || $page === 'register' || $page === 'verify' || $page === 'forgot_password' || $page === 'reset_password') {
    require_once 'app/controllers/AuthController.php';
    $controller = new AuthController();
    if ($page === 'login') {
        $controller->login();
    } elseif ($page === 'register') {
        $controller->register();
    } elseif ($page === 'verify') {
        $controller->verify();
    } elseif ($page === 'forgot_password') {
        $controller->forgotPassword();
    } elseif ($page === 'reset_password') {
        $controller->resetPassword();
    }
    exit;
}

// Authentication Guard for protected routes
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit;
}

if ($page === 'logout') {
    require_once 'app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->logout();
    exit;
}

// Simple MVC Routing
switch ($page) {
    case 'dashboard':
        require_once 'app/controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'transactions':
        require_once 'app/controllers/TransactionsController.php';
        $controller = new TransactionsController();
        $controller->index();
        break;

    case 'reports':
        require_once 'app/controllers/ReportsController.php';
        $controller = new ReportsController();
        $controller->index();
        break;

    case 'profile':
        require_once 'app/controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;

    default:
        // 404
        require_once 'app/controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;
}
