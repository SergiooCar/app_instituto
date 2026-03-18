<?php

//models\horarioDAO.php
require_once 'bd.php';
require_once 'horario.php';

Class HorarioDAO {

    private MyDB $db;

    public function __construct() {
        $this->db = new MyDB();
    }

    public function existeTablaHorarios() {
        $q = "SELECT COUNT(*) as total
              FROM information_schema.TABLES
              WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'horarios'";
        $items = $this->db->myPrepQuery($q);
        return (int)($items[0]['total'] ?? 0) > 0;
    }

    public function getAll() {
        $q = "SELECT * FROM horarios ORDER BY aula_id, dia, hora_inicio ASC";
        $items = $this->db->myPrepQuery($q);
        return $this->filasToHorarios($items);
    }

    public function getByAulaId($aula_id) {
        $q = "SELECT * FROM horarios WHERE aula_id = :aula_id ORDER BY dia, hora_inicio ASC";
        $items = $this->db->myPrepQuery($q, [':aula_id' => $aula_id]);
        return $this->filasToHorarios($items);
    }

    public function get($id) {
        $q = "SELECT * FROM horarios WHERE id = :id";
        $items = $this->db->myPrepQuery($q, [':id' => $id]);
        if(count($items) == 1) return new Horario($items[0]);
        return null;
    }

    public function crear($datos) {
        $q = "INSERT INTO horarios (aula_id, dia, hora_inicio, hora_fin, bloque, profesor, curso) 
              VALUES (:aula_id, :dia, :hora_inicio, :hora_fin, :bloque, :profesor, :curso)";
        $this->db->myPrepQuery($q, [
            ':aula_id' => $datos['aula_id'] ?? 0,
            ':dia' => $datos['dia'] ?? '',
            ':hora_inicio' => $datos['hora_inicio'] ?? '',
            ':hora_fin' => $datos['hora_fin'] ?? '',
            ':bloque' => $datos['bloque'] ?? '',
            ':profesor' => $datos['profesor'] ?? '',
            ':curso' => $datos['curso'] ?? ''
        ]);
    }

    public function actualizar($id, $datos) {
        $q = "UPDATE horarios SET aula_id = :aula_id, dia = :dia, hora_inicio = :hora_inicio, 
              hora_fin = :hora_fin, bloque = :bloque, profesor = :profesor, curso = :curso 
              WHERE id = :id";
        $this->db->myPrepQuery($q, [
            ':id' => $id,
            ':aula_id' => $datos['aula_id'] ?? 0,
            ':dia' => $datos['dia'] ?? '',
            ':hora_inicio' => $datos['hora_inicio'] ?? '',
            ':hora_fin' => $datos['hora_fin'] ?? '',
            ':bloque' => $datos['bloque'] ?? '',
            ':profesor' => $datos['profesor'] ?? '',
            ':curso' => $datos['curso'] ?? ''
        ]);
    }

    public function eliminar($id) {
        $q = "DELETE FROM horarios WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
    }

    private function filasToHorarios($items) {
        $result = [];
        foreach($items as $fila)
            $result[] = new Horario($fila);
        return $result;
    }

}//class
