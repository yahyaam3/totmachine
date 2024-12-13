<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\User;

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
        // Set inner_view to auth/login.php
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

    // Handle logout
    public function logout(Request $request, Response $response, Container $container)
    {
        session_destroy();
        $response->redirect("Location: /");
        return $response;
    }
}