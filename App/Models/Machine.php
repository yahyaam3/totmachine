<?php
namespace App\Models;

use PDO;

class Machine extends BaseModel
{
    /**
     * Validates latitude and longitude values.
     */
    public function validateCoordinates($latitude, $longitude)
    {
        return is_numeric($latitude) && is_numeric($longitude) &&
               $latitude >= -90 && $latitude <= 90 &&
               $longitude >= -180 && $longitude <= 180;
    }

    /**
     * Adds a new machine to the database.
     */
    public function addMachine($model, $manufacturer, $serial_number, $start_date, $latitude, $longitude, $image = '', $technician_id = null)
    {
        if (!$this->validateCoordinates($latitude, $longitude)) {
            throw new \Exception("Invalid latitude or longitude");
        }

        $stmt = $this->db->prepare("INSERT INTO Machines (model, manufacturer, serial_number, start_date, latitude, longitude, image, technician_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$model, $manufacturer, $serial_number, $start_date, $latitude, $longitude, $image, $technician_id]);
    }

    /**
     * Fetches a machine by its ID.
     */
    public function getMachine($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Machines WHERE id_machine = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Fetches a machine by its ID - used for validation.
     */
    public function findMachineById($id)
    {
        $stmt = $this->db->prepare("SELECT id_machine FROM Machines WHERE id_machine = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna la fila si existeix, o false si no
    }

    /**
     * Lists all machines with technician usernames.
     */
    public function listMachines()
    {
        $stmt = $this->db->query("SELECT m.*, u.username AS technician_username FROM Machines m LEFT JOIN Users u ON m.technician_id = u.id_user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lists machines with only necessary fields for the map.
     */
    public function listMachinesForMap()
    {
        $stmt = $this->db->query("SELECT id_machine, model, latitude, longitude FROM Machines WHERE latitude IS NOT NULL AND longitude IS NOT NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Assigns a technician to a machine.
     */
    public function assignTechnician($machine_id, $tech_id)
    {
        $stmt = $this->db->prepare("UPDATE Machines SET technician_id = ? WHERE id_machine = ?");
        return $stmt->execute([$tech_id, $machine_id]);
    }

    /**
     * Searches machines by model, manufacturer, or serial number.
     */
    public function searchMachines($query)
    {
        $stmt = $this->db->prepare("SELECT * FROM Machines WHERE model LIKE ? OR manufacturer LIKE ? OR serial_number LIKE ?");
        $wild = "%$query%";
        $stmt->execute([$wild, $wild, $wild]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Imports machines from a CSV file.
     */
    public function bulkImportFromCSV($file)
    {
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Expecting: model, manufacturer, serial_number, start_date, latitude, longitude
                $this->addMachine($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], '', null);
            }
            fclose($handle);
        }
    }

    /**
     * Deletes a machine by its ID.
     */
    public function deleteMachine($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Machines WHERE id_machine = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Updates a machine's data.
     */
    public function updateMachine($id, $model, $manufacturer, $serial)
    {
        $stmt = $this->db->prepare("UPDATE Machines SET model = ?, manufacturer = ?, serial_number = ? WHERE id_machine = ?");
        return $stmt->execute([$model, $manufacturer, $serial, $id]);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getUnassignedMachines() {
        $stmt = $this->db->query("SELECT * FROM Machines WHERE technician_id IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTechnicianMachines($technicianId) {
        $stmt = $this->db->prepare("SELECT * FROM Machines WHERE technician_id = ?");
        $stmt->execute([$technicianId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}