<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Kuldeep
 * @description Core backend logic component.
 */
require_once 'app/config/database.php';

/**
 * Class User
 * Handles database operations related to user accounts, authentication, and profiles.
 */
class User {
    private $conn;

    /**
     * Initializes a new User model instance and establishes a database connection.
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Authenticates a user by email and password.
     *
     * @param string $email The user's email address.
     * @param string $password The user's plaintext password.
     * @return array|bool Returns user data on success, or false on failure.
     */
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password_hash'])) {
                return $user;
            }
        }
        return false;
    }

    /**
     * Registers a new user account.
     *
     * @param string $fullName The user's full name.
     * @param string $email The user's email address.
     * @param string $password The user's plaintext password.
     * @param string $otpCode The generated OTP code for email verification.
     * @return bool Returns true on success, false on failure.
     */
    public function register($fullName, $email, $password, $otpCode) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        $query = "INSERT INTO users (full_name, email, password_hash, is_verified, otp_code, otp_expires_at) 
                  VALUES (:full_name, :email, :password_hash, 0, :otp_code, :otp_expires_at)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $hash);
        $stmt->bindParam(':otp_code', $otpCode);
        $stmt->bindParam(':otp_expires_at', $expiresAt);
        
        return $stmt->execute();
    }

    /**
     * Verifies the user's OTP code.
     *
     * @param string $email The user's email address.
     * @param string $code The OTP code submitted by the user.
     * @return array|bool Returns user data on success, or false if invalid/expired.
     */
    public function verifyOTP($email, $code) {
        $query = "SELECT * FROM users WHERE email = :email AND otp_code = :code AND is_verified = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            if (strtotime($user['otp_expires_at']) > time()) {
                // Update to verified
                $update = "UPDATE users SET is_verified = 1, otp_code = NULL, otp_expires_at = NULL WHERE id = :id";
                $upStmt = $this->conn->prepare($update);
                $upStmt->bindParam(':id', $user['id']);
                $upStmt->execute();
                return $user;
            }
        }
        return false;
    }
    
    /**
     * Retrieves basic user details by ID.
     *
     * @param int $id The user's ID.
     * @return array|bool Returns user data, or false if not found.
     */
    public function getUser($id) {
        $query = "SELECT id, full_name, email, currency_preference, base_budget, total_savings FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Updates the user's base budget.
     *
     * @param int $id The user's ID.
     * @param float $newBudget The new base budget amount.
     * @return bool Returns true on success, false on failure.
     */
    public function updateBudget($id, $newBudget) {
        $query = "UPDATE users SET base_budget = :base_budget WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':base_budget', $newBudget);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Updates the user's total savings by adding the specified amount.
     *
     * @param int $id The user's ID.
     * @param float $amount The amount to add to savings.
     * @return bool Returns true on success, false on failure.
     */
    public function updateSavings($id, $amount) {
        // Amount is passed as a value to add to current savings
        $query = "UPDATE users SET total_savings = total_savings + :amount WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    /**
     * Updates the user's profile details.
     *
     * @param int $id The user's ID.
     * @param string $fullName The new full name.
     * @param string $email The new email address.
     * @return bool Returns true on success, false on failure.
     */
    public function updateProfile($id, $fullName, $email) {
        $query = "UPDATE users SET full_name = :full_name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Updates the user's password.
     *
     * @param int $id The user's ID.
     * @param string $newPassword The new plaintext password.
     * @return bool Returns true on success, false on failure.
     */
    public function updatePassword($id, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $query = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password_hash', $hash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Updates the user's currency preference.
     *
     * @param int $id The user's ID.
     * @param string $currencySymbol The chosen currency symbol or string.
     * @return bool Returns true on success, false on failure.
     */
    public function updateCurrency($id, $currencySymbol) {
        $query = "UPDATE users SET currency_preference = :currency_preference WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':currency_preference', $currencySymbol);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
