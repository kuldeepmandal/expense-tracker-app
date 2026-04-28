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
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'update_profile') {
                $fullName = $_POST['full_name'] ?? '';
                $email = $_POST['email'] ?? '';
                if ($userModel->updateProfile($userId, $fullName, $email)) {
                    $message = "Profile updated successfully.";
                } else {
                    $error = "Failed to update profile.";
                }
            } elseif ($action === 'update_security') {
                $password = $_POST['new_password'] ?? '';
                if (strlen($password) >= 6) {
                    if ($userModel->updatePassword($userId, $password)) {
                        $message = "Password updated successfully.";
                    } else {
                        $error = "Failed to update password.";
                    }
                } else {
                    $error = "Password must be at least 6 characters long.";
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
