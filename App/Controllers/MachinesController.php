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
        $response->set("inner_view", "machines/list.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function detail(Request $request, Response $response, Container $container)
    {
        $id = $request->getParam("id");
        $machine = $this->machineModel->getMachine($id);

        // Generate QR code  (recordar instalar GD para el php)
        // recordar cambiar la url a la correcta cuando se suba al server
        $qr = new QrCode("http://localhost:80/machines/detail/" . $id);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        $qrPath = $container["config"]["paths"]["uploads"] . "machines/qr_" . $id . ".png";
        $result->saveToFile($qrPath);
        $relativeQrPath = "uploads/machines/qr_" . $id . ".png";

        $response->set("machine", $machine);
        $response->set("qr_path", $relativeQrPath);
        $response->set("inner_view", "machines/detail.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function addMachine(Request $request, Response $response, Container $container)
    {
        $response->set("inner_view", "machines/add_form.php");
        $response->setTemplate("layout/base.php");
        return $response;
    }

    public function storeMachine(Request $request, Response $response, Container $container)
    {
        // Get basic machine data
        $model = $request->get(INPUT_POST, "model");
        $manufacturer = $request->get(INPUT_POST, "manufacturer");
        $serial = $request->get(INPUT_POST, "serial_number");
        $start_date = $request->get(INPUT_POST, "start_date");
        $lat = $request->get(INPUT_POST, "latitude");
        $lon = $request->get(INPUT_POST, "longitude");

        $image = '';
        $uploadDir = $container["config"]["paths"]["uploads"] . "machines/";

        try {
            // Create upload directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Check for webcam image first
            $webcamImage = $request->get(INPUT_POST, "webcam_image");
            if ($webcamImage && strpos($webcamImage, 'base64') !== false) {
                // Process base64 webcam image
                $data = explode(',', $webcamImage);
                $imageData = base64_decode($data[1]);
                
                // Generate unique filename
                $filename = "machine_" . time() . "_webcam.jpg";
                
                // Save the image
                if (file_put_contents($uploadDir . $filename, $imageData)) {
                    $image = "uploads/machines/" . $filename;
                }
            }
            // If no webcam image, try file upload
            elseif (isset($_FILES['image']) && $_FILES['image']['tmp_name'] !== '') {
                $filename = "machine_" . time() . "_upload.jpg";
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                    $image = "uploads/machines/" . $filename;
                }
            }

            // Add machine to database
            $this->machineModel->addMachine(
                $model,
                $manufacturer,
                $serial,
                $start_date,
                $lat,
                $lon,
                $image,
                null
            );

            $response->redirect("Location: /machines/list");
            return $response;

        } catch (\Exception $e) {
            // Log error and redirect with error message
            error_log("Error storing machine: " . $e->getMessage());
            $_SESSION['error'] = "Error storing machine. Please try again.";
            $response->redirect("Location: /machines/add");
            return $response;
        }
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

    public function ajaxEditForm(Request $request, Response $response, Container $container)
    {
        $id = $request->get(INPUT_GET, "id");
        if (!$id) {
            echo json_encode(["result" => "error", "message" => "Missing machine ID"]);
            exit;
        }

        $machine = $this->machineModel->getMachine($id);
        
        if ($machine) {
            ob_start();
            include __DIR__ . "/../Views/modal/edit_machine_form.php";
            $html = ob_get_clean();
            echo $html;
        } else {
            echo json_encode(["result" => "error", "message" => "Machine not found"]);
        }
        exit;
    }    

public function ajaxUpdate(Request $request, Response $response, Container $container)
{
    $id = $request->get(INPUT_POST, "id");
    $model = $request->get(INPUT_POST, "model");
    $manufacturer = $request->get(INPUT_POST, "manufacturer");
    $serial = $request->get(INPUT_POST, "serial_number");

    $success = $this->machineModel->updateMachine($id, $model, $manufacturer, $serial);

    if ($success) {
        echo json_encode(["result" => "ok"]);
    } else {
        echo json_encode(["result" => "error", "message" => "Failed to update machine"]);
    }
    exit;
}   
}