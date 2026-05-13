<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/models/User.php';

/**
 * Class ProfileController
 * Manages user profile settings, including personal info, password, and preferences.
 */
class ProfileController {
    /**
     * Displays the profile page and handles profile update requests.
     * Redirects to login if user is not authenticated.
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $userModel = new User();
        $user = $userModel->getUser($userId);
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'update_profile') {
                $fullName = $_POST['full_name'] ?? '';
                $newEmail = $_POST['email'] ?? '';

                if ($newEmail !== $user['email']) {
                    $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $_SESSION['pending_email'] = $newEmail;
                    $_SESSION['pending_full_name'] = $fullName;
                    $_SESSION['email_change_otp'] = $otpCode;
                    
                    require_once 'app/config/MailService.php';
                    $mailService = new MailService();
                    $mailService->sendOTP($newEmail, $otpCode);
                    
                    $message = "An OTP has been sent to your new email address. Please verify it below.";
                } else {
                    if ($userModel->updateProfile($userId, $fullName, $user['email'])) {
                        $message = "Profile updated successfully.";
                        $user = $userModel->getUser($userId); // Refresh
                    } else {
                        $error = "Failed to update profile.";
                    }
                }
            } elseif ($action === 'verify_email_change') {
                $submittedOtp = $_POST['otp'] ?? '';
                if (isset($_SESSION['email_change_otp']) && $submittedOtp === $_SESSION['email_change_otp']) {
                    $newEmail = $_SESSION['pending_email'];
                    $fullName = $_SESSION['pending_full_name'];
                    if ($userModel->updateProfile($userId, $fullName, $newEmail)) {
                        $message = "Email updated successfully.";
                        unset($_SESSION['pending_email'], $_SESSION['pending_full_name'], $_SESSION['email_change_otp']);
                        $user = $userModel->getUser($userId); // Refresh
                    } else {
                        $error = "Failed to update profile.";
                    }
                } else {
                    $error = "Invalid or expired OTP code.";
                }
            } elseif ($action === 'cancel_email_change') {
                unset($_SESSION['pending_email'], $_SESSION['pending_full_name'], $_SESSION['email_change_otp']);
                $message = "Email change cancelled.";
            } elseif ($action === 'update_security') {
                $password = $_POST['new_password'] ?? '';
                
                if (strlen($password) < 6 || strlen($password) > 12) {
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
                    if ($userModel->updatePassword($userId, $password)) {
                        $message = "Password updated successfully.";
                    } else {
                        $error = "Failed to update password.";
                    }
                }
            } elseif ($action === 'update_preferences') {
                $currency = $_POST['currency_preference'] ?? 'Rs.';
                if ($userModel->updateCurrency($userId, $currency)) {
                    $message = "Preferences updated successfully.";
                } else {
                    $error = "Failed to update preferences.";
                }
            }
        }

        $user = $userModel->getUser($userId);
        
        $page = 'profile';
        $view = 'app/views/profile.php';
        require_once 'app/views/layout.php';
    }
}
?>
