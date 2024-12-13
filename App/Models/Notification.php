<?php
namespace App\Models;

use PDO;

class Notification extends BaseModel
{
    public function createNotification($message, $id_user)
    {
        $sent_date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO Notifications (message,sent_date,id_user) VALUES (?,?,?)");
        return $stmt->execute([$message, $sent_date, $id_user]);
    }

    public function listForUser($id_user)
    {
        $stmt = $this->db->prepare("SELECT * FROM Notifications WHERE id_user=? ORDER BY sent_date DESC");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead($id_notification)
    {
        $stmt = $this->db->prepare("UPDATE Notifications SET is_read=1 WHERE id_notification=?");
        return $stmt->execute([$id_notification]);
    }
}