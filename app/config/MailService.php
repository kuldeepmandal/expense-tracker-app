<?php
/**
 * Finance Tracker Application - Prototype
 * 
 * @author Prajwan
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Construct relative path to vendor directory correctly depending on where it's included from
$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

/**
 * Class MailService
 * Handles sending emails using PHPMailer (e.g., OTPs).
 */
class MailService {
    /**
     * @var PHPMailer The PHPMailer instance used for sending emails.
     */
    private $mail;

    /**
     * Initializes the MailService and configures the SMTP settings.
     */
    public function __construct() {
        $this->mail = new PHPMailer(true);
        try {
            // Server settings
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com'; 
            $this->mail->SMTPAuth   = true;
            // TODO: REPLACE WITH VALID CREDENTIALS
            $this->mail->Username   = 'kuldeepmandal609@gmail.com'; 
            $this->mail->Password   = 'rqdtqtowdbicgnrm'; 
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;

            // Sender address
            $this->mail->setFrom('no-reply@spendly.com', 'Spendly');
        } catch (Exception $e) {
            error_log("Mailer Init Error: " . $e->getMessage());
        }
    }

    /**
     * Sends a One-Time Password (OTP) to the specified email address.
     *
     * @param string $userEmail The recipient's email address.
     * @param string $otpCode The OTP code to send.
     * @return bool Returns true if email was sent successfully, false otherwise.
     */
    public function sendOTP($userEmail, $otpCode) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($userEmail);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Your Spendly Verification Code';
            $this->mail->Body    = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #1E293B;'>
                <h2 style='color: #0B8A61;'>Spendly Verification</h2>
                <p>Hello,</p>
                <p>Thank you for signing up for Spendly! To complete your registration and verify your email address, please use the following one-time password:</p>
                <div style='background-color: #F1F5F9; padding: 20px; text-align: center; border-radius: 8px; font-size: 24px; font-weight: bold; letter-spacing: 4px; margin: 20px 0;'>
                    {$otpCode}
                </div>
                <p>This code will expire in 15 minutes.</p>
            </div>";
            $this->mail->AltBody = "Your verification code is: {$otpCode}. It expires in 15 minutes.";

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }
}
?>
