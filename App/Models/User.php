<?php
namespace App\Models;

use PDO;

class User extends BaseModel
{
    /**
     * Crea un nou usuari amb validació de contrasenya.
     */
    public function createUser($name, $surname, $email, $username, $password, $role, $avatar = '')
    {
        // Validació de contrasenya: 6-13 caràcters, lletres, números i almenys 1 lletra i 1 número
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\-]{6,13}$/', $password)) {
            return false;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Users (name, surname, email, username, password, avatar, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $surname, $email, $username, $hashed, $avatar, $role]);
    }

    /**
     * Obté un usuari pel seu nom d'usuari.
     */
    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obté un usuari pel seu ID.
     */
    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualitza la informació d'un usuari.
     */
    public function updateUser($id, $name, $surname, $email)
    {
        $stmt = $this->db->prepare("UPDATE Users SET name = ?, surname = ?, email = ? WHERE id_user = ?");
        return $stmt->execute([$name, $surname, $email, $id]);
    }

    /**
     * Llista tots els usuaris.
     */
    public function listUsers()
    {
        $stmt = $this->db->query("SELECT * FROM Users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Llista només els usuaris amb el rol 'TECHNICAL'.
     */
    public function listTechnicians()
    {
        $stmt = $this->db->query("SELECT id_user, username FROM Users WHERE role = 'TECHNICAL'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica la contrasenya d'un usuari.
     */
    public function verifyPassword($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // Rehash si és necessari
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("UPDATE Users SET password = ? WHERE id_user = ?");
                $stmt->execute([$newHash, $user['id_user']]);
            }
            return $user;
        }
        return false;
    }

    /**
     * Actualitza el rol d'un usuari.
     */
    public function setUserRole($id, $role)
    {
        $stmt = $this->db->prepare("UPDATE Users SET role = ? WHERE id_user = ?");
        return $stmt->execute([$role, $id]);
    }

    /**
     * Elimina un usuari pel seu ID.
     */
    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE id_user = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Guarda el token per restablir la contrasenya.
     */
    public function saveResetToken($email, $token)
    {
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $stmt = $this->db->prepare("UPDATE Users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        return $stmt->execute([$token, $expiry, $email]);
    }

    /**
     * Verifica si el token és vàlid.
     */
    public function verifyResetToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE reset_token = ? AND token_expiry > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualitza la contrasenya utilitzant el token.
     */
    public function updatePasswordByToken($token, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE Users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
        return $stmt->execute([$hashedPassword, $token]);
    }

    /**
     * Obté l'últim ID inserit.
     */
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * Obté un usuari pel seu correu electrònic.
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateResetToken($email, $token, $expiresAt) {
        $stmt = $this->db->prepare("UPDATE Users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        return $stmt->execute([$token, $expiresAt, $email]);
    }

    public function getUserByToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE reset_token = ? AND token_expiry > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($token, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE Users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ? AND token_expiry > NOW()");
        return $stmt->execute([$hashedPassword, $token]);
    }
}