<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\Incident;
//test
class IncidentsController
{
    protected $db;
    protected $incidentModel;
//test
    public function __construct($db)
    {
        $this->db = $db;
        $this->incidentModel = new Incident($db);
    }

    public function list(Request $request, Response $response, Container $container)
    {
        $incidents = $this->incidentModel->listIncidents();
        $response->set("incidents", $incidents);
        $response->set("inner_view", "incidents/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function detail(Request $request, Response $response, Container $container)
    {
        $id = $request->getParam("id");
        $incident = $this->incidentModel->getIncident($id);
        $response->set("incident", $incident);
        $response->set("inner_view", "incidents/detail.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function updateStatus(Request $request, Response $response, Container $container)
    {
        $id = $request->getParam("id");
        $status = $request->get(INPUT_POST, "status");
        $this->incidentModel->updateIncidentStatus($id, $status);
        $response->redirect("Location: /incidents/list");
        return $response;
    }

    public function assignToSelf(Request $request, Response $response, Container $container)
    {
        $id = $request->getParam("id");
        $user_id = $_SESSION['user_id'];
        $this->incidentModel->assignIncident($id, $user_id);
        $response->redirect("Location: /incidents/list");
        return $response;
    }
}