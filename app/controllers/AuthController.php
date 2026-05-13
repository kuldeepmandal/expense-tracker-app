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
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if ($password !== $confirmPassword) {
                $error = "Passwords do not match.";
            } elseif (strlen($password) < 6 || strlen($password) > 12) {
                $error = "Password must be between 6 and 12 characters.";
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $error = "Password must include at least one uppercase letter.";
            } elseif (!preg_match('/[a-z]/', $password)) {
                $error = "Password must include at least one lowercase letter.";
            } elseif (!preg_match('/[0-9]/', $password)) {
                $error = "Password must include at least one number.";
            } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
                $error = "Password must include at least one special character.";
            }

            if (isset($error)) {
                $page = 'register';
                $view = 'app/views/register.php';
                require_once 'app/views/layout.php';
                return;
            }
            
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
     * Handles the forgot password request.
     */
    public function forgotPassword() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $email = $_POST['email'] ?? '';
            $user = $userModel->getUserByEmail($email);
            
            if ($user) {
                $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $userModel->setResetOTP($user['id'], $otpCode);
                
                $mailService = new MailService();
                $mailService->sendOTP($email, $otpCode);
                
                $_SESSION['reset_user_id'] = $user['id'];
                $_SESSION['reset_email'] = $email;
                header("Location: index.php?page=reset_password");
                exit;
            } else {
                $error = "No account found with that email address.";
                $page = 'forgot_password';
                $view = 'app/views/forgot_password.php';
                require_once 'app/views/layout.php';
                return;
            }
        }

        $page = 'forgot_password';
        $view = 'app/views/forgot_password.php';
        require_once 'app/views/layout.php';
    }

    /**
     * Handles resetting the password using OTP.
     */
    public function resetPassword() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }
        if (!isset($_SESSION['reset_user_id'])) {
            header("Location: index.php?page=forgot_password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $otp = $_POST['otp'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $userId = $_SESSION['reset_user_id'];
            
            if ($password !== $confirmPassword) {
                $error = "Passwords do not match.";
            } elseif (strlen($password) < 6 || strlen($password) > 12) {
                $error = "Password must be between 6 and 12 characters.";
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $error = "Password must include at least one uppercase letter.";
            } elseif (!preg_match('/[a-z]/', $password)) {
                $error = "Password must include at least one lowercase letter.";
            } elseif (!preg_match('/[0-9]/', $password)) {
                $error = "Password must include at least one number.";
            } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
                $error = "Password must include at least one special character.";
            } else {
                if ($userModel->verifyResetOTP($userId, $otp)) {
                    $userModel->updatePassword($userId, $password);
                    unset($_SESSION['reset_user_id'], $_SESSION['reset_email']);
                    $success = "Password has been reset successfully!";
                    $page = 'reset_password';
                    $view = 'app/views/reset_password.php';
                    require_once 'app/views/layout.php';
                    return;
                } else {
                    $error = "Invalid or expired OTP.";
                }
            }

            if (isset($error)) {
                $page = 'reset_password';
                $view = 'app/views/reset_password.php';
                require_once 'app/views/layout.php';
                return;
            }
        }

        $page = 'reset_password';
        $view = 'app/views/reset_password.php';
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
