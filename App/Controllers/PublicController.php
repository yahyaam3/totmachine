<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\Machine;
use App\Models\Incident;

class PublicController
{
    protected $db;
    protected $machineModel;
    protected $incidentModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->machineModel = new Machine($db);
        $this->incidentModel = new Incident($db);
    }

    public function index(Request $request, Response $response, Container $container)
    {
        // Obtenir la llista de màquines
        $machines = $this->machineModel->listMachines();
        $response->set("machines", $machines);
        $response->set("inner_view", "public/index.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function registerIncidentPublic(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "auth/register_incident_public.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function storeIncidentPublic(Request $request, Response $response, Container $container)
    {
        // Recollir dades del formulari
        $description = htmlspecialchars($request->get(INPUT_POST, "description"), ENT_QUOTES, 'UTF-8');
        $priority = htmlspecialchars($request->get(INPUT_POST, "priority"), ENT_QUOTES, 'UTF-8');
        $machine_id = filter_input(INPUT_POST, "machine_id", FILTER_VALIDATE_INT);

        // Validacions de les dades
        if (empty($description)) {
            throw new \Exception("Description is required.");
        }

        if (!$priority) {
            $priority = 'LOW'; // Assigna valor per defecte
        }

        if ($machine_id === false) {
            throw new \Exception("Invalid Machine ID. It must be a valid integer.");
        }

        // Comprovar si la màquina existeix
        $machineExists = $this->machineModel->findMachineById($machine_id);
        if (!$machineExists) {
            throw new \Exception("Machine with ID {$machine_id} does not exist.");
        }

        // Crear la incidència
        $this->incidentModel->createIncident($description, $priority, $machine_id, null);

        // Redirigir amb missatge d'èxit
        $response->redirect("Location: /?msg=incident_created");
        return $response;
    }
}
