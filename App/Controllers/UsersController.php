<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\User;

class UsersController
{
    protected $db;
    protected $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function list(Request $request, Response $response, Container $container)
    {
        $users = $this->userModel->listUsers();
        $response->set("users", $users);
        $response->set("inner_view", "users/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function profile(Request $request, Response $response, Container $container)
    {
        $id = $_SESSION['user_id'] ?? null;
        if (!$id) {
            $response->redirect("Location: /");
            return $response;
        }
        $user = $this->userModel->getUserById($id);
        $response->set("user", $user);
        $response->set("inner_view", "users/profile.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function updateProfile(Request $request, Response $response, Container $container)
    {
        $id = $_SESSION['user_id'];
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $email = $request->get(INPUT_POST, "email");

        // Handle avatar upload if any
        $avatar = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name'] !== '') {
            $uploadDir = $container["config"]["paths"]["uploads"] . "users/";
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0777, true);
            $filename = "user_" . $id . "_" . time() . ".jpg";
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename);
            $avatar = "uploads/users/" . $filename;
        }

        $this->userModel->updateUser($id, $name, $surname, $email, $avatar);
        $response->redirect("Location: /users/profile");
        return $response;
    }

    public function addUser(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "users/add_form.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function storeUser(Request $request, Response $response, Container $container)
    {
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $email = $request->get(INPUT_POST, "email");
        $username = $request->get(INPUT_POST, "username");
        $password = $request->get(INPUT_POST, "password");
        $role = $request->get(INPUT_POST, "role");

        // Handle avatar
        $avatar = '';
        if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name'] !== '') {
            $uploadDir = $container["config"]["paths"]["uploads"] . "users/";
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0777, true);
            $filename = "user_" . time() . ".jpg";
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename);
            $avatar = "uploads/users/" . $filename;
        }

        $res = $this->userModel->createUser($name, $surname, $email, $username, $password, $role, $avatar);
        if ($res) {
            $response->redirect("Location: /users/list");
        } else {
            $response->setSession("error", "User creation failed, check password policy.");
            $response->redirect("Location: /users/add");
        }
        return $response;
    }

    public function ajaxEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id");
    
        if (!$id || !is_numeric($id)) {
            echo json_encode(["result" => "error", "message" => "Invalid User ID"]);
            exit;
        }
    
        $user = $this->userModel->getUserById($id);
    
        if ($user) {
            ob_start();
            include __DIR__ . "/../Views/modal/edit_user_form.php";
            $html = ob_get_clean();
            echo $html;
        } else {
            echo json_encode(["result" => "error", "message" => "User not found"]);
        }
        exit;
    }
    
    public function ajaxUpdate(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id");
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $email = $request->get(INPUT_POST, "email");

        if ($this->userModel->updateUser($id, $name, $surname, $email)) {
            echo json_encode(["result" => "ok"]);
        } else {
            echo json_encode(["result" => "error", "message" => "Failed to update user"]);
        }
        exit;
    }
    public function ajaxDelete(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id");

        if (!$id || !is_numeric($id)) {
            echo json_encode(["result" => "error", "message" => "Invalid ID"]);
            exit;
        }

        $deleted = $this->userModel->deleteUser($id);

        if ($deleted) {
            echo json_encode(["result" => "ok", "id" => $id]);
        } else {
            echo json_encode(["result" => "error", "message" => "Failed to delete user"]);
        }
        exit;
    }
}