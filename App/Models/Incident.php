<?php
namespace App\Models;

use PDO;

class Incident extends BaseModel
{
    public function createIncident($description, $priority, $id_machine = null, $id_user = null)
    {
        $status = 'WAITING';
        $issued_date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO Incidents (description,priority,status,issued_date,id_machine,id_user) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$description, $priority, $status, $issued_date, $id_machine, $id_user]);
    }

    public function listIncidents()
    {
        $stmt = $this->db->query("SELECT i.*, m.model as machine_model, u.username as user_username FROM Incidents i 
                                  LEFT JOIN Machines m ON i.id_machine=m.id_machine 
                                  LEFT JOIN Users u ON i.id_user=u.id_user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIncident($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Incidents WHERE id_incident=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateIncidentStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE Incidents SET status=? WHERE id_incident=?");
        return $stmt->execute([$status, $id]);
    }

    public function assignIncident($id_incident, $id_user)
    {
        $stmt = $this->db->prepare("UPDATE Incidents SET id_user=? WHERE id_incident=?");
        return $stmt->execute([$id_user, $id_incident]);
    }

    public function filterByMachine($id_machine)
    {
        $stmt = $this->db->prepare("SELECT * FROM Incidents WHERE id_machine=?");
        $stmt->execute([$id_machine]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}