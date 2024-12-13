<?php
namespace App\Controllers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use App\Models\Machine;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class MachinesController
{
    protected $db;
    protected $machineModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->machineModel = new Machine($db);
    }

    public function list(Request $request, Response $response, Container $container)
    {
        $machines = $this->machineModel->listMachines();

        $response->set("machines", $machines);
        $response->set("leaflet", true); // Activar Leaflet en esta vista
        $response->set("inner_view", "machines/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function detail(Request $request, Response $response, Container $container)
    {
        $id = $request->getParam("id");
        $machine = $this->machineModel->getMachine($id);

        // Generar código QR
        $qr = new QrCode("http://localhost:80/machines/detail/" . $id);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        $qrPath = $container["config"]["paths"]["uploads"] . "machines/qr_" . $id . ".png";
        $result->saveToFile($qrPath);
        $relativeQrPath = "uploads/machines/qr_" . $id . ".png";

        $response->set("machine", $machine);
        $response->set("qr_path", $relativeQrPath);
        $response->set("leaflet", true); // Activar Leaflet en esta vista
        $response->set("inner_view", "machines/detail.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function addMachine(Request $request, Response $response, Container $container)
    {
        $response->set("leaflet", true); // Activar Leaflet en esta vista
        $response->set("inner_view", "machines/add_form.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function storeMachine(Request $request, Response $response, Container $container)
    {
        $model = $request->get(INPUT_POST, "model");
        $manufacturer = $request->get(INPUT_POST, "manufacturer");
        $serial = $request->get(INPUT_POST, "serial_number");
        $start_date = $request->get(INPUT_POST, "start_date");
        $lat = $request->get(INPUT_POST, "latitude") ?: null; // Coordenadas opcionales
        $lon = $request->get(INPUT_POST, "longitude") ?: null;

        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] !== '') {
            $uploadDir = $container["config"]["paths"]["uploads"] . "machines/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = "machine_" . time() . ".jpg";
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
            $image = "uploads/machines/" . $filename;
        }

        $this->machineModel->addMachine($model, $manufacturer, $serial, $start_date, $lat, $lon, $image, null);
        $response->redirect("Location: /machines/list");
        return $response;
    }

    public function importCSV(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "machines/csv_import.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function handleImportCSV(Request $request, Response $response, Container $container)
    {
        if (isset($_FILES['csv']) && $_FILES['csv']['tmp_name'] !== '') {
            $this->machineModel->bulkImportFromCSV($_FILES['csv']['tmp_name']);
        }
        $response->redirect("Location: /machines/list");
        return $response;
    }
}
