<?php
namespace App\Controllers;
//test
use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\User;
use App\Models\Machine;

class AjaxController
{
    protected $db;
    protected $userModel;
    protected $machineModel;
//test
    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new User($db);
        $this->machineModel = new Machine($db);
    }
//test
    public function randomUser(Request $request, Response $response, Container $container)
    {
        $role = $request->get(INPUT_GET, "role");
        if (!$role)
            $role = 'TECHNICAL';

        $data = file_get_contents("https://randomuser.me/api/");
        $json = json_decode($data, true);
        $userRandom = $json['results'][0];
//test
        $name = ucfirst($userRandom['name']['first']);
        $surname = ucfirst($userRandom['name']['last']);
        $email = $userRandom['email'];
        $username = $userRandom['login']['username'];
        $password = "testing10";
        $avatar = $userRandom['picture']['large'];

        // Download avatar locally
        $uploadDir = $container["config"]["paths"]["uploads"] . "users/";
        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0777, true);
        $imgData = file_get_contents($avatar);
        $filename = "user_" . time() . ".jpg";
        file_put_contents($uploadDir . $filename, $imgData);
        $avatarPath = "uploads/users/" . $filename;

        $this->userModel->createUser($name, $surname, $email, $username, $password, $role, $avatarPath);
        $response->setJSON();
        $response->set("result", "ok");
        return $response;
    }

    public function searchMachines(Request $request, Response $response, Container $container)
    {
        $query = $request->get(INPUT_GET, "q");
        $machines = $this->machineModel->searchMachines($query);
        $response->setJSON();
        $response->set("machines", $machines);
        return $response;
    }

    // AJAX endpoint to load user edit form in a modal
    public function userEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id", "FILTER_VALIDATE_INT");
        $user = $this->userModel->getUserById($id);

        // Render form as HTML (In a real scenario, we would put this in a separate view)
        ob_start();
        include __DIR__ . "/../../App/Views/modal/edit_user_form.php";
        $html = ob_get_clean();

        $response->setBody($html);
        return $response;
    }

    // AJAX endpoint to update user via form submission (JSON response)
    public function userUpdate(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", "FILTER_VALIDATE_INT");
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $email = $request->get(INPUT_POST, "email");

        $this->userModel->updateUser($id, $name, $surname, $email);
        $response->setJSON();
        $response->set("result", "ok");
        return $response;
    }

    // Similar AJAX for machine edit form
    public function machineEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id", "FILTER_VALIDATE_INT");
        $machine = $this->machineModel->getMachine($id);

        ob_start();
        include __DIR__ . "/../../App/Views/modal/edit_machine_form.php";
        $html = ob_get_clean();

        $response->setBody($html);
        return $response;
    }

    public function machineUpdate(Request $request, Response $response, Container $container)
    {
        // Implement machine update logic here
        // ...
        $response->setJSON();
        $response->set("result", "ok");
        return $response;
    }

    public function userDelete(Request $request, Response $response, Container $container) {
        $id = $request->get(INPUT_POST,"id","FILTER_VALIDATE_INT");
        $this->userModel->deleteUser($id);
        $response->setJSON();
        $response->set("result","ok");
        return $response;
    }
    
    public function machineDelete(Request $request, Response $response, Container $container) {
        $id = $request->get(INPUT_POST,"id","FILTER_VALIDATE_INT");
        $this->machineModel->deleteMachine($id);
        $response->setJSON();
        $response->set("result","ok");
        return $response;
    }
    
}