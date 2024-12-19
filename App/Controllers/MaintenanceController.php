<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\Maintenance;
use Dompdf\Dompdf;

class MaintenanceController
{
    protected $db;
    protected $maintenanceModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->maintenanceModel = new Maintenance($db);
    }

    // List maintenance records
    public function list(Request $request, Response $response, Container $container)
    {
        try {
            $maintenance = $this->maintenanceModel->listMaintenance();
            $response->set("maintenance", $maintenance);
        } catch (\Exception $e) {
            $response->set("error", "Error fetching maintenance records: " . $e->getMessage());
        }

        // Check if there's a success or error message from session
        if (isset($_SESSION['success'])) {
            $response->set("success", $_SESSION['success']);
            unset($_SESSION['success']);  // Clear success message after displaying it
        }
        if (isset($_SESSION['error'])) {
            $response->set("error", $_SESSION['error']);
            unset($_SESSION['error']);  // Clear error message after displaying it
        }

        $response->set("inner_view", "maintenance/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    // Show the add maintenance form
    public function add(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "maintenance/add_form.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    // Store maintenance record
    public function store(Request $request, Response $response, Container $container)
    {
        $type = $request->get(INPUT_POST, "type");
        $description = $request->get(INPUT_POST, "description");
        $date = $request->get(INPUT_POST, "date");
        $time_spent = filter_input(INPUT_POST, "time_spent", FILTER_VALIDATE_INT);
        $machine_id = filter_input(INPUT_POST, "machine_id", FILTER_VALIDATE_INT);
        $user_id = $_SESSION['user_id'];

        // Validate the form data
        if (!$type || !$description || !$date || !$time_spent || !$machine_id) {
            $_SESSION['error'] = "Please fill in all required fields with valid data.";
            $response->redirect("/maintenance/add");
            return $response;
        }

        try {
            // Create the maintenance record
            $this->maintenanceModel->createMaintenance($type, $description, $date, $time_spent, $machine_id, $user_id);

            // Set success message and redirect to the list page
            $_SESSION['success'] = "Maintenance record added successfully!";
            $response->redirect("/maintenance/list");  // This redirects to the list page after the action
        } catch (\Exception $e) {
            // Handle the exception and display an error message
            $_SESSION['error'] = "Error creating maintenance record: " . $e->getMessage();
            $response->redirect("/maintenance/add");  // Redirect back to the add form on error
        }

        return $response;
    }

    // Download maintenance history PDF for a specific machine
    public function downloadPDF(Request $request, Response $response, Container $container)
    {
        $machine_id = $request->getParam("id");

        try {
            // Fetch maintenance records for the given machine
            $maintenance = $this->maintenanceModel->maintenanceForMachine($machine_id);

            if (!$maintenance) {
                throw new \Exception("No maintenance records found for this machine.");
            }

            // Generate the PDF content
            $html = "<h1>Maintenance History</h1>";
            foreach ($maintenance as $m) {
                $html .= "<p><strong>{$m['type']}</strong> - {$m['description']} ({$m['date']}, {$m['time_spent']} hours)</p>";
            }

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream("maintenance_history_{$machine_id}.pdf", ["Attachment" => 0]);
        } catch (\Exception $e) {
            $response->set("error", "Error generating PDF: " . $e->getMessage());
            $response->set("inner_view", "maintenance/list.php");
            $response->setTemplate("layout/base.php");
        }

        exit;
    }

    // Handle delete maintenance request
    public function deleteMaintenance(Request $request, Response $response, Container $container)
    {
        $id = $request->getParam("id");

        try {
            // Delete the maintenance record
            $this->maintenanceModel->deleteMaintenance($id);

            // Set success message and redirect
            $_SESSION['success'] = "Maintenance record deleted successfully!";
            $response->redirect("/maintenance/list");  // Redirect to the list page after deletion
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error deleting maintenance record: " . $e->getMessage();
            $response->redirect("/maintenance/list");  // Redirect to the list page on error
        }

        return $response;
    }

    public function schedulePreventiveMaintenance(Request $request, Response $response, Container $container) {
        $machineId = $request->get(INPUT_POST, "machine_id");
        $technicianId = $request->get(INPUT_POST, "technician_id");
        $date = $request->get(INPUT_POST, "date");
        $description = $request->get(INPUT_POST, "description");
        
        $success = $this->maintenanceModel->createMaintenance(
            'PREVENTIVE',
            $description,
            $date,
            0, // time_spent será actualizado cuando se complete
            $machineId,
            $technicianId
        );
        
        $response->setJSON();
        if ($success) {
            $response->set("result", "ok");
        } else {
            $response->set("result", "error");
        }
        return $response;
    }
}
