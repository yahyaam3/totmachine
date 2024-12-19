<?php
namespace App\Models;

use PDO;

class Maintenance extends BaseModel
{
    public function createMaintenance($type, $description, $date, $time_spent, $id_machine, $id_user)
    {
        $stmt = $this->db->prepare("INSERT INTO Maintenance (type,description,date,time_spent,id_machine,id_user) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$type, $description, $date, $time_spent, $id_machine, $id_user]);
    }

    public function listMaintenance()
    {
        $stmt = $this->db->query("SELECT mt.*, m.model as machine_model, u.username as user_username 
                                  FROM Maintenance mt 
                                  LEFT JOIN Machines m ON mt.id_machine=m.id_machine 
                                  LEFT JOIN Users u ON mt.id_user=u.id_user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaintenance($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Maintenance WHERE id_maintenance=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function maintenanceForMachine($id_machine)
    {
        $stmt = $this->db->prepare("SELECT * FROM Maintenance WHERE id_machine=?");
        $stmt->execute([$id_machine]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateMaintenance($id, $type, $description, $date, $time_spent)
    {
        $stmt = $this->db->prepare("UPDATE Maintenance SET type = ?, description = ?, date = ?, time_spent = ? WHERE id_maintenance = ?");
        return $stmt->execute([$type, $description, $date, $time_spent, $id]);
    }

    public function deleteMaintenance($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Maintenance WHERE id_maintenance = ?");
        return $stmt->execute([$id]);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}