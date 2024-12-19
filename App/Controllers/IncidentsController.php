<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\Incident;
use App\Models\User;

class IncidentsController
{
    protected $db;
    protected $incidentModel;
    protected $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->incidentModel = new Incident($db);
        $this->userModel = new User($db); // Cargamos el modelo de usuarios para los técnicos
    }

    /**
     * List all incidents. If user is SUPERVISOR or ADMINISTRATOR, fetch technicians as well.
     */
    public function list(Request $request, Response $response, Container $container)
    {
        // Obtener los incidentes
        $incidents = $this->incidentModel->listIncidents();

        // Obtener los técnicos solo para los roles de SUPERVISOR o ADMINISTRATOR
        $technicians = [];
        if (in_array($_SESSION['user_role'] ?? '', ['SUPERVISOR', 'ADMINISTRATOR'])) {
            $technicians = $this->userModel->listTechnicians();
        }

        // Pasamos los datos a la vista
        $response->set("incidents", $incidents);
        $response->set("technicians", $technicians);
        $response->set("inner_view", "incidents/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    /**
     * Update the status and priority of an incident.
     */
    public function updateStatus(Request $request, Response $response, Container $container)
    {
        $id = filter_var($request->getParam("id"), FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
        $priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_STRING);

        if (!$id || !$status || !$priority) {
            return $response->json(['success' => false, 'message' => 'Invalid input data.']);
        }

        // Actualizamos el estado y la prioridad
        $updated = $this->incidentModel->updateIncidentStatus($id, $status, $priority);

        if ($updated) {
            return $response->json(['success' => true]);
        } else {
            return $response->json(['success' => false, 'message' => 'Error updating the incident.']);
        }
    }

    /**
     * Assign the incident to the current user (TECHNICAL role only).
     */
    public function assignToSelf(Request $request, Response $response, Container $container)
    {
        $id = filter_var($request->getParam("id"), FILTER_VALIDATE_INT);
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$id || !$user_id) {
            throw new \Exception("Invalid request. User not authenticated or invalid incident ID.");
        }

        // Asignamos el incidente al usuario actual
        $this->incidentModel->assignIncident($id, $user_id);

        // Redirigir con mensaje de éxito
        $response->redirect("Location: /incidents/list?msg=incident_assigned");
        return $response;
    }

    /**
     * Assign the incident to a technician (only for SUPERVISOR or ADMINISTRATOR).
     */
    public function assign(Request $request, Response $response, Container $container)
    {
        // Validamos los datos de entrada
        $incident_id = filter_input(INPUT_POST, "incident_id", FILTER_VALIDATE_INT);
        $technician_id = filter_input(INPUT_POST, "technician_id", FILTER_VALIDATE_INT);

        if (!$incident_id || !$technician_id) {
            throw new \Exception("Invalid input data. Both Incident ID and Technician ID are required.");
        }

        // Verificamos los permisos del usuario
        if (!in_array($_SESSION['user_role'] ?? '', ['SUPERVISOR', 'ADMINISTRATOR'])) {
            throw new \Exception("Permission denied. Only supervisors or administrators can assign incidents.");
        }

        // Asignamos el incidente al técnico seleccionado
        $this->incidentModel->assignIncident($incident_id, $technician_id);

        // Redirigir con mensaje de éxito
        $response->redirect("Location: /incidents/list?msg=technician_assigned");
        return $response;
    }

    /**
     * Assign a technician to an incident via AJAX.
     */
    public function assignTechnician(Request $request, Response $response, Container $container)
    {
        $incident_id = filter_input(INPUT_POST, "incident_id", FILTER_VALIDATE_INT);
        $technician_id = filter_input(INPUT_POST, "technician_id", FILTER_VALIDATE_INT);

        if (!$incident_id || !$technician_id) {
            return $response->json(['success' => false, 'message' => 'Invalid input data.']);
        }

        // Verificamos los permisos del usuario
        if (!in_array($_SESSION['user_role'] ?? '', ['SUPERVISOR', 'ADMINISTRATOR'])) {
            return $response->json(['success' => false, 'message' => 'Permission denied.']);
        }

        // Asignamos el técnico al incidente
        $assigned = $this->incidentModel->assignIncident($incident_id, $technician_id);

        if ($assigned) {
            // Respondemos con éxito y el nombre del técnico asignado
            return $response->json(['success' => true, 'technician_username' => $this->userModel->getUser($technician_id)['username']]);
        } else {
            return $response->json(['success' => false, 'message' => 'Error assigning technician.']);
        }
    }
}


