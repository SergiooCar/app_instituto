<?php

//models\userDAO.php
require_once 'bd.php';
require_once 'user.php';

Class UserDAO {

    private MyDB $db;

    public function __construct() {
        $this->db = new MyDB();
    }

    public function validar($username, $pass) {

        $q = "SELECT id, username, password_hash, role, created_at 
              FROM users WHERE username = :username";
        $items = $this->db->myPrepQuery($q, [':username' => $username]);

        $result = null;

        if(count($items) == 1) {
            if(password_verify($pass, $items[0]['password_hash']) && ($items[0]['role'] ?? '') !== 'disabled') {
                $result = new User($items[0]);
            }
        }

        return $result;
    }

    public function getAll() {
        $q = "SELECT id, username, role, created_at FROM users ORDER BY id";
        $items = $this->db->myPrepQuery($q);
        return $this->filasToUsers($items);
    }

    public function crear($datos) {
        // Comprobar si ya existe
        $q = "SELECT id FROM users WHERE username = :username";
        $items = $this->db->myPrepQuery($q, [':username' => $datos['username']]);
        
        if(count($items) > 0) {
            return "El usuario ".$datos['username']." ya esta registrado.";
        }

        $q = "INSERT INTO users (username, password_hash, role) 
              VALUES (:username, :password_hash, :role)";
        $this->db->myPrepQuery($q, [
            ':username' => $datos['username'],
            ':password_hash' => password_hash($datos['password'], PASSWORD_DEFAULT),
            ':role' => $datos['role'] ?? 'viewer'
        ]);

        return "";
    }

    public function cambiarRol($id, $role) {
        $q = "UPDATE users SET role = :role WHERE id = :id";
        $this->db->myPrepQuery($q, [':role' => $role, ':id' => $id]);
    }

    public function actualizarUsername($id, $username) {
        $q = "SELECT id FROM users WHERE username = :username AND id <> :id";
        $items = $this->db->myPrepQuery($q, [
            ':username' => $username,
            ':id' => $id
        ]);

        if(count($items) > 0) {
            return "Ese nombre de usuario ya existe.";
        }

        $q = "UPDATE users SET username = :username WHERE id = :id";
        $this->db->myPrepQuery($q, [
            ':username' => $username,
            ':id' => $id
        ]);

        return "";
    }

    public function actualizarPassword($id, $password) {
        $q = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
        $this->db->myPrepQuery($q, [
            ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
            ':id' => $id
        ]);
    }

    public function eliminar($id) {
        $q = "DELETE FROM users WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
    }

    private function asegurarTablaRecuperaciones() {
        $q = "CREATE TABLE IF NOT EXISTS password_reset_requests (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                estado VARCHAR(20) NOT NULL DEFAULT 'pendiente',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                resolved_at TIMESTAMP NULL DEFAULT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->myPrepQuery($q);
    }

    public function registrarSolicitudRecuperacion($username) {
        $this->asegurarTablaRecuperaciones();
        $q = "INSERT INTO password_reset_requests (username, estado) VALUES (:username, 'pendiente')";
        $this->db->myPrepQuery($q, [':username' => $username]);
    }

    public function getSolicitudesRecuperacionPendientes() {
        $this->asegurarTablaRecuperaciones();
        $q = "SELECT id, username, estado, created_at
              FROM password_reset_requests
              WHERE estado = 'pendiente'
              ORDER BY created_at DESC";
        return $this->db->myPrepQuery($q);
    }

    public function marcarSolicitudRecuperacionAtendida($id) {
        $this->asegurarTablaRecuperaciones();
        $q = "UPDATE password_reset_requests
              SET estado = 'atendida', resolved_at = NOW()
              WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
    }

    private function filasToUsers($items) {
        $result = [];
        foreach($items as $fila)
            $result[] = new User($fila);
        return $result;
    }

}//class
 