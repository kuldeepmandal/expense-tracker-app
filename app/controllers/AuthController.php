<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/models/User.php';
require_once 'app/config/MailService.php';

/**
 * Class AuthController
 * Handles user authentication including login, registration, verification, and logout.
 */
class AuthController {
    
    /**
     * Handles user login and redirects to the dashboard upon success.
     */
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $userModel->login($email, $password);
            
            if ($user && $user['is_verified']) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php?page=dashboard");
                exit;
            } elseif ($user && !$user['is_verified']) {
                // Not verified, redirect to verify context
                header("Location: index.php?page=verify&email=" . urlencode($user['email']));
                exit;
            } else {
                $error = "Invalid email or password.";
                $page = 'login';
                $view = 'app/views/login.php';
                require_once 'app/views/layout.php';
                return;
            }
        }

        $page = 'login';
        $view = 'app/views/login.php';
        require_once 'app/views/layout.php';
    }

    /**
     * Handles user registration, creates an account, and sends an OTP for verification.
     */
    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $fullName = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            if ($userModel->register($fullName, $email, $password, $otpCode)) {
                $mailService = new MailService();
                $mailService->sendOTP($email, $otpCode);
                header("Location: index.php?page=verify&email=" . urlencode($email));
                exit;
            } else {
                $error = "Registration failed. Email might already exist.";
                $page = 'register';
                $view = 'app/views/register.php';
                require_once 'app/views/layout.php';
                return;
            }
        }

        $page = 'register';
        $view = 'app/views/register.php';
        require_once 'app/views/layout.php';
    }

    /**
     * Verifies the user's email address using the provided OTP.
     */
    public function verify() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $email = $_POST['email'] ?? '';
            $code = $_POST['code'] ?? '';
            
            $user = $userModel->verifyOTP($email, $code);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php?page=dashboard");
                exit;
            } else {
                $error = "Invalid or expired OTP code.";
                $page = 'verify';
                $view = 'app/views/verify.php';
                require_once 'app/views/layout.php';
                return;
            }
        }

        $page = 'verify';
        $view = 'app/views/verify.php';
        require_once 'app/views/layout.php';
    }

    /**
     * Logs out the user by destroying the session and redirects to the login page.
     */
    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>
