<?php
namespace App\Models;
use PDO;

class User extends BaseModel
{
    public function createUser($name, $surname, $email, $username, $password, $role, $avatar = '')
    {
        // Validate password via regex: 6-13 chars, letters, numbers, dashes, at least 1 letter and 1 number
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\-]{6,13}$/', $password)) {
            return false;
        }
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Users (name,surname,email,username,password,avatar,role) VALUES (?,?,?,?,?,?,?)");
        return $stmt->execute([$name, $surname, $email, $username, $hashed, $avatar, $role]);
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE username=?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE id_user=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $surname, $email, $avatar = null)
    {
        $sql = "UPDATE Users SET name=?, surname=?, email=?";
        $params = [$name, $surname, $email];
        if ($avatar) {
            $sql .= ", avatar=?";
            $params[] = $avatar;
        }
        $sql .= " WHERE id_user=?";
        $params[] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function listUsers()
    {
        $stmt = $this->db->query("SELECT * FROM Users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // Rehash if needed
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("UPDATE Users SET password=? WHERE id_user=?");
                $stmt->execute([$newHash, $user['id_user']]);
            }
            return $user;
        }
        return false;
    }

    public function setUserRole($id, $role)
    {
        $stmt = $this->db->prepare("UPDATE Users SET role=? WHERE id_user=?");
        return $stmt->execute([$role, $id]);
    }
    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE id_user=?");
        return $stmt->execute([$id]);
    }

}