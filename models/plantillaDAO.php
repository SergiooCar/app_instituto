<?php

//models\plantillaDAO.php
require_once 'bd.php';
require_once 'plantilla.php';

Class PlantillaDAO {

    private MyDB $db;

    public function __construct() {
        $this->db = new MyDB();
    }

    public function getAll() {
        $q = "SELECT id, nombre, contenido, created_at FROM etiqueta_plantillas ORDER BY id DESC";
        $items = $this->db->myPrepQuery($q);
        return $this->filasToPlantillas($items);
    }

    public function crear($nombre, $contenido) {
        $q = "INSERT INTO etiqueta_plantillas (nombre, contenido) VALUES (:nombre, :contenido)";
        $this->db->myPrepQuery($q, [':nombre' => $nombre, ':contenido' => $contenido]);
    }

    public function eliminar($id) {
        $q = "DELETE FROM etiqueta_plantillas WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
    }

    private function filasToPlantillas($items) {
        $result = [];
        foreach($items as $fila)
            $result[] = new Plantilla($fila);
        return $result;
    }

}//class
 