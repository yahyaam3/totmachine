<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\User;
use App\Models\Machine;
use App\Models\Incident;
use App\Models\Maintenance;

class AjaxController
{
    protected $db;
    protected $userModel;
    protected $machineModel;
    protected $incidentModel;
    protected $maintenanceModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new User($db);
        $this->machineModel = new Machine($db);
        $this->incidentModel = new Incident($db);
        $this->maintenanceModel = new Maintenance($db);
    }

    public function randomUser(Request $request, Response $response, Container $container)
    {
        $role = $request->get(INPUT_GET, "role");
        if (!$role)
            $role = 'TECHNICAL';

        $data = file_get_contents("https://randomuser.me/api/");
        $json = json_decode($data, true);
        $userRandom = $json['results'][0];

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
        $id = $request->get(INPUT_GET, "id", FILTER_VALIDATE_INT); // Use constant directly
        if (!$id) {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Invalid user ID");
            return $response;
        }

        $user = $this->userModel->getUserById($id);
        
        if ($user) {
            ob_start();
            include __DIR__ . "/../Views/modal/edit_user_form.php";
            $html = ob_get_clean();
            $response->setBody($html);
        } else {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "User not found");
        }
        return $response;
    }

    // AJAX endpoint to update user via form submission (JSON response)
    public function userUpdate(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $email = $request->get(INPUT_POST, "email");

        if ($id && $name && $surname && $email) {
            $success = $this->userModel->updateUser($id, $name, $surname, $email);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to update user");
            }
        }
        return $response;
    }

    // Similar AJAX for machine edit form
    public function machineEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id", FILTER_VALIDATE_INT); // Use constant directly
        if (!$id) {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Invalid machine ID");
            return $response;
        }

        $machine = $this->machineModel->getMachine($id);
        
        if ($machine) {
            ob_start();
            include __DIR__ . "/../Views/modal/edit_machine_form.php";
            $html = ob_get_clean();
            $response->setBody($html);
        } else {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Machine not found");
        }
        return $response;
    }

    public function machineUpdate(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $model = $request->get(INPUT_POST, "model");
        $manufacturer = $request->get(INPUT_POST, "manufacturer");
        $serial = $request->get(INPUT_POST, "serial_number");

        if ($id && $model && $manufacturer && $serial) {
            $success = $this->machineModel->updateMachine($id, $model, $manufacturer, $serial);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to update machine");
            }
        }
        return $response;
    }

    public function userDelete(Request $request, Response $response, Container $container) 
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if ($id) {
            $success = $this->userModel->deleteUser($id);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to delete user");
            }
        } else {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Invalid user ID");
        }
        return $response;
    }

    public function machineDelete(Request $request, Response $response, Container $container) 
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if ($id) {
            $success = $this->machineModel->deleteMachine($id);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to delete machine");
            }
        } else {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Invalid machine ID");
        }
        return $response;
    }

    public function incidentEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if (!$id) {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Invalid incident ID");
            return $response;
        }

        $incident = $this->incidentModel->getIncident($id);
        
        if ($incident) {
            ob_start();
            include __DIR__ . "/../Views/modal/edit_incident_form.php";
            $html = ob_get_clean();
            $response->setBody($html);
        }
        return $response;
    }

    public function incidentUpdate(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $description = $request->get(INPUT_POST, "description");
        $priority = $request->get(INPUT_POST, "priority");
        $status = $request->get(INPUT_POST, "status");

        if ($id && $description && $priority && $status) {
            $success = $this->incidentModel->updateIncident($id, $description, $priority, $status);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to update incident");
            }
        }
        return $response;
    }

    public function maintenanceEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if (!$id) {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", "Invalid maintenance ID");
            return $response;
        }

        $maintenance = $this->maintenanceModel->getMaintenance($id);
        
        if ($maintenance) {
            ob_start();
            include __DIR__ . "/../Views/modal/edit_maintenance_form.php";
            $html = ob_get_clean();
            $response->setBody($html);
        }
        return $response;
    }

    public function maintenanceUpdate(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $type = $request->get(INPUT_POST, "type");
        $description = $request->get(INPUT_POST, "description");
        $date = $request->get(INPUT_POST, "date");
        $time_spent = $request->get(INPUT_POST, "time_spent", FILTER_VALIDATE_INT);

        if ($id && $type && $description && $date && $time_spent) {
            $success = $this->maintenanceModel->updateMaintenance($id, $type, $description, $date, $time_spent);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to update maintenance");
            }
        }
        return $response;
    }

    public function incidentDelete(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if ($id) {
            $success = $this->incidentModel->deleteIncident($id);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to delete incident");
            }
        }
        return $response;
    }

    public function maintenanceDelete(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if ($id) {
            $success = $this->maintenanceModel->deleteMaintenance($id);
            $response->setJSON();
            if ($success) {
                $response->set("result", "ok");
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to delete maintenance");
            }
        }
        return $response;
    }

    public function machineAddForm(Request $request, Response $response, Container $container)
    {
        // Get technicians list for the form
        $userModel = new \App\Models\User($this->db);
        $technicians = $userModel->listTechnicians();
        
        ob_start();
        include __DIR__ . "/../Views/modal/add_machine_form.php";
        $html = ob_get_clean();
        $response->setBody($html);
        return $response;
    }

    public function machineStore(Request $request, Response $response, Container $container)
    {
        $model = $request->get(INPUT_POST, "model");
        $manufacturer = $request->get(INPUT_POST, "manufacturer");
        $serial = $request->get(INPUT_POST, "serial_number");
        $start_date = $request->get(INPUT_POST, "start_date");
        $lat = $request->get(INPUT_POST, "latitude");
        $lon = $request->get(INPUT_POST, "longitude");
        $technician_id = $request->get(INPUT_POST, "technician_id");

        try {
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] !== '') {
                $uploadDir = "uploads/machines/";
                $filename = "machine_" . time() . "_" . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                    $image = $uploadDir . $filename;
                }
            }

            $id = $this->machineModel->addMachine(
                $model,
                $manufacturer,
                $serial,
                $start_date,
                $lat,
                $lon,
                $image,
                $technician_id
            );

            $response->setJSON();
            if ($id) {
                $response->set("result", "ok");
                $response->set("machine", [
                    'id_machine' => $id,
                    'model' => $model,
                    'manufacturer' => $manufacturer,
                    'serial_number' => $serial
                ]);
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to create machine");
            }
        } catch (\Exception $e) {
            $response->setJSON();
            $response->set("result", "error");
            $response->set("message", $e->getMessage());
        }
        
        return $response;
    }

    public function userAddForm(Request $request, Response $response, Container $container)
    {
        ob_start();
        include __DIR__ . "/../Views/modal/add_user_form.php";
        $html = ob_get_clean();
        $response->setBody($html);
        return $response;
    }

    public function userStore(Request $request, Response $response, Container $container)
    {
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $email = $request->get(INPUT_POST, "email");
        $username = $request->get(INPUT_POST, "username");
        $password = $request->get(INPUT_POST, "password");
        $role = $request->get(INPUT_POST, "role");

        if ($name && $surname && $email && $username && $password && $role) {
            $success = $this->userModel->createUser($name, $surname, $email, $username, $password, $role);
            $response->setJSON();
            if ($success) {
                $id = $this->userModel->getLastInsertId();
                $response->set("result", "ok");
                $response->set("user", [
                    'id_user' => $id,
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $email,
                    'username' => $username,
                    'role' => $role
                ]);
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to create user");
            }
        }
        return $response;
    }

    public function maintenanceAddForm(Request $request, Response $response, Container $container)
    {
        ob_start();
        include __DIR__ . "/../Views/modal/add_maintenance_form.php";
        $html = ob_get_clean();
        $response->setBody($html);
        return $response;
    }

    public function maintenanceStore(Request $request, Response $response, Container $container)
    {
        $type = $request->get(INPUT_POST, "type");
        $description = $request->get(INPUT_POST, "description");
        $date = $request->get(INPUT_POST, "date");
        $time_spent = $request->get(INPUT_POST, "time_spent", FILTER_VALIDATE_INT);
        $machine_id = $request->get(INPUT_POST, "machine_id", FILTER_VALIDATE_INT);
        $user_id = $_SESSION['user_id'];

        if ($type && $description && $date && $time_spent && $machine_id) {
            $success = $this->maintenanceModel->createMaintenance(
                $type,
                $description,
                $date,
                $time_spent,
                $machine_id,
                $user_id
            );
            
            $response->setJSON();
            if ($success) {
                $id = $this->maintenanceModel->getLastInsertId();
                $response->set("result", "ok");
                $response->set("maintenance", [
                    'id_maintenance' => $id,
                    'type' => $type,
                    'description' => $description,
                    'date' => $date,
                    'time_spent' => $time_spent
                ]);
            } else {
                $response->set("result", "error");
                $response->set("message", "Failed to create maintenance");
            }
        }
        return $response;
    }
}