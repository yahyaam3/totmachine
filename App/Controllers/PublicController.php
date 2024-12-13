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
        $description = $request->get(INPUT_POST, "description");
        $priority = $request->get(INPUT_POST, "priority", "FILTER_SANITIZE_STRING");
        $machine_id = $request->get(INPUT_POST, "machine_id", "FILTER_VALIDATE_INT");
        if (!$priority)
            $priority = 'LOW';

        $this->incidentModel->createIncident($description, $priority, $machine_id, null);
        $response->redirect("Location: /?msg=incident_created");
        return $response;
    }
}