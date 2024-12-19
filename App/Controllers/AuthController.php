<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    protected $db;
    protected $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    // Show login form
    public function showLogin(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "auth/login.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    // Handle login
    public function login(Request $request, Response $response, Container $container)
    {
        $username = $request->get(INPUT_POST, "username");
        $password = $request->get(INPUT_POST, "password");
        $user = $this->userModel->verifyPassword($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $response->redirect("Location: /");
        } else {
            $response->setSession("error", "Invalid credentials");
            $response->redirect("Location: /login");
        }
        return $response;
    }

    // Show forgot password form
    public function showForgotPassword(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "auth/forgot-password.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    // Handle forgot password
    public function forgotPassword(Request $request, Response $response, Container $container) {
        $email = $request->get(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

        if ($email) {
            $user = $this->userModel->getUserByEmail($email);
            if (!$user) {
                $response->setSession("error", "Email not found.");
                $response->redirect("Location: /forgot-password");
                return $response;
            }

            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $this->userModel->saveResetToken($email, $token);

            // Create reset link using current domain
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
            $domain = $_SERVER['HTTP_HOST'];
            $resetLink = $protocol . $domain . "/reset-password?token=" . $token;

            // Configure PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USER'];
                $mail->Password = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $_ENV['SMTP_PORT'];

                $mail->setFrom($_ENV['MAIL_FROM'], 'Maintenance System');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "
                    <h2>Password Reset Request</h2>
                    <p>Click the link below to reset your password:</p>
                    <p><a href='{$resetLink}'>{$resetLink}</a></p>
                    <p>This link will expire in 1 hour.</p>
                    <p>If you did not request this reset, please ignore this email.</p>
                ";

                $mail->send();
                $response->setSession("success", "Reset link sent to your email. Please check your inbox.");
            } catch (Exception $e) {
                $response->setSession("error", "Failed to send email. Please try again later.");
            }
        } else {
            $response->setSession("error", "Invalid email address.");
        }

        $response->redirect("Location: /forgot-password");
        return $response;
    }

    // Show reset password form
    public function showResetPassword(Request $request, Response $response, Container $container)
    {
        $response->set("token", $request->get(INPUT_GET, "token"));
        $response->set("inner_view", "auth/reset-password.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    // Handle reset password
    public function resetPassword(Request $request, Response $response, Container $container)
    {
        $token = $request->get(INPUT_POST, "token");
        $newPassword = $request->get(INPUT_POST, "password");

        if ($this->userModel->verifyResetToken($token)) {
            $this->userModel->updatePasswordByToken($token, $newPassword);
            $response->setSession("success", "Password reset successfully. You can now login.");
            $response->redirect("Location: /login");
        } else {
            $response->setSession("error", "Invalid or expired token.");
            $response->redirect("Location: /reset-password?token=$token");
        }

        return $response;
    }

    // Handle logout
    public function logout(Request $request, Response $response, Container $container)
    {
        session_destroy();
        $response->redirect("Location: /");
        return $response;
    }
}
