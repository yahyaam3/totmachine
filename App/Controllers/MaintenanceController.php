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

    public function list(Request $request, Response $response, Container $container)
    {
        $maintenance = $this->maintenanceModel->listMaintenance();
        $response->set("maintenance", $maintenance);
        $response->set("inner_view", "maintenance/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function add(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "maintenance/add_form.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function store(Request $request, Response $response, Container $container)
    {
        $type = $request->get(INPUT_POST, "type");
        $description = $request->get(INPUT_POST, "description");
        $date = $request->get(INPUT_POST, "date");
        $time_spent = $request->get(INPUT_POST, "time_spent", "FILTER_VALIDATE_INT");
        $machine_id = $request->get(INPUT_POST, "machine_id", "FILTER_VALIDATE_INT");
        $user_id = $_SESSION['user_id'];

        $this->maintenanceModel->createMaintenance($type, $description, $date, $time_spent, $machine_id, $user_id);
        $response->redirect("Location: /maintenance/list");
        return $response;
    }

    public function downloadPDF(Request $request, Response $response, Container $container)
    {
        $machine_id = $request->getParam("id");
        $maintenance = $this->maintenanceModel->maintenanceForMachine($machine_id);

        // Generate PDF
        $html = "<h1>Maintenance History</h1>";
        foreach ($maintenance as $m) {
            $html .= "<p>{$m['type']} - {$m['description']} ({$m['date']}, {$m['time_spent']}h)</p>";
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("maintenance_history.pdf", ["Attachment" => 0]);
        exit;
    }
}