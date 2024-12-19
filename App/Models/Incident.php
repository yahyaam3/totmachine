<?php 
namespace App\Models;

use PDO;

class Incident extends BaseModel
{
    public function createIncident($description, $priority, $id_machine = null, $id_user = null)
    {
        // Comprobar si id_machine existe (si se proporciona)
        if ($id_machine !== null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM Machines WHERE id_machine = ?");
            $stmt->execute([$id_machine]);
            if ($stmt->fetchColumn() == 0) {
                throw new \Exception("Machine ID {$id_machine} does not exist.");
            }
        }

        // Insertar la incidencia
        $status = 'WAITING';
        $issued_date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("
            INSERT INTO Incidents (description, priority, status, issued_date, id_machine, id_user) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$description, $priority, $status, $issued_date, $id_machine, $id_user]);
    }

    public function listIncidents()
    {
        // Ajuste en la consulta SQL para obtener el técnico correctamente
        $stmt = $this->db->query(" 
            SELECT i.*, m.model as machine_model, u.username as user_username, 
            t.username as technician_username
            FROM Incidents i 
            LEFT JOIN Machines m ON i.id_machine = m.id_machine 
            LEFT JOIN Users u ON i.id_user = u.id_user 
            LEFT JOIN Users t ON i.id_user = t.id_user  -- Relacionar correctamente el técnico asignado
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIncident($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Incidents WHERE id_incident = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateIncidentStatus($id, $status, $priority) 
    {
        // Actualizar tanto el estado como la prioridad
        $stmt = $this->db->prepare("UPDATE Incidents SET status = ?, priority = ? WHERE id_incident = ?");
        return $stmt->execute([$status, $priority, $id]);
    }

    public function assignIncident($id_incident, $id_user)
    {
        // Asignar el incidente a un técnico
        $stmt = $this->db->prepare("UPDATE Incidents SET id_user = ? WHERE id_incident = ?");
        return $stmt->execute([$id_user, $id_incident]);
    }

    // Función para obtener técnicos (solo para SUPERVISOR o ADMIN)
    public function listTechnicians()
    {
        $stmt = $this->db->query("SELECT id_user, username FROM Users WHERE role = 'TECHNICIAN'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterByMachine($id_machine)
    {
        $stmt = $this->db->prepare("SELECT * FROM Incidents WHERE id_machine = ?");
        $stmt->execute([$id_machine]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateIncident($id, $description, $priority, $status)
    {
        $stmt = $this->db->prepare("UPDATE Incidents SET description = ?, priority = ?, status = ? WHERE id_incident = ?");
        return $stmt->execute([$description, $priority, $status, $id]);
    }

    public function deleteIncident($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Incidents WHERE id_incident = ?");
        return $stmt->execute([$id]);
    }
    
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getTechnicianIncidents($technicianId) {
        $stmt = $this->db->prepare("SELECT * FROM Incidents WHERE id_user = ?");
        $stmt->execute([$technicianId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnassignedIncidents() {
        $stmt = $this->db->query("SELECT * FROM Incidents WHERE id_user IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
