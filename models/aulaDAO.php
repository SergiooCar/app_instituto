<?php

//models\aulaDAO.php
require_once 'bd.php';
require_once 'aula.php';

Class AulaDAO {

    private MyDB $db;
    private ?bool $aulasTieneDiaHora = null;
    private ?bool $aulasTieneSoloLogo = null;

    public function __construct() {
        $this->db = new MyDB();
    }

    private function tieneSoloLogo() {
        if($this->aulasTieneSoloLogo !== null) return $this->aulasTieneSoloLogo;
        $q = "SELECT COUNT(*) as total FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'aulas' AND COLUMN_NAME = 'solo_logo'";
        $items = $this->db->myPrepQuery($q);
        $tiene = ((int)($items[0]['total'] ?? 0) === 1);
        if(!$tiene) {
            $this->db->myPrepQuery("ALTER TABLE aulas ADD COLUMN solo_logo TINYINT(1) NOT NULL DEFAULT 0");
            $tiene = true;
        }
        $this->aulasTieneSoloLogo = $tiene;
        return $this->aulasTieneSoloLogo;
    }

    private function tieneColumnasDiaHora() {
        if($this->aulasTieneDiaHora !== null) return $this->aulasTieneDiaHora;

        $q = "SELECT COUNT(*) as total
              FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'aulas'
              AND COLUMN_NAME IN ('dia', 'hora')";
        $items = $this->db->myPrepQuery($q);
        $this->aulasTieneDiaHora = ((int)($items[0]['total'] ?? 0) === 2);
        return $this->aulasTieneDiaHora;
    }

    public function getAll() {
        $q = "SELECT * FROM aulas ORDER BY nombre ASC";
        $items = $this->db->myPrepQuery($q);
        return $this->filasToAulas($items);
    }

    public function get($id) {
        $q = "SELECT * FROM aulas WHERE id = :id";
        $items = $this->db->myPrepQuery($q, [':id' => $id]);
        if(count($items) == 1) return new Aula($items[0]);
        return null;
    }

    public function resolverIdParaHorarioCSV($aulaRef, $bloque = '', $curso = '', $profesor = '') {
        $aulaRef = trim((string) $aulaRef);
        $bloque = trim((string) $bloque);
        $curso = trim((string) $curso);
        $profesor = trim((string) $profesor);

        //Si viene un id numerico y existe, usarlo.
        if($aulaRef !== '' && ctype_digit($aulaRef)) {
            $id = (int) $aulaRef;
            if($id > 0 && $this->get($id) !== null) {
                return $id;
            }
        }

        //Buscar por nombre exacto.
        if($aulaRef !== '') {
            $q = "SELECT id FROM aulas WHERE nombre = :nombre LIMIT 1";
            $items = $this->db->myPrepQuery($q, [':nombre' => $aulaRef]);
            if(count($items) > 0) return (int) $items[0]['id'];

            //Buscar por formato comun: Aula X
            $q2 = "SELECT id FROM aulas WHERE nombre = :nombre LIMIT 1";
            $items2 = $this->db->myPrepQuery($q2, [':nombre' => 'Aula '.$aulaRef]);
            if(count($items2) > 0) return (int) $items2[0]['id'];
        }

        // Fallback por bloque+curso(+profesor)
        if($bloque !== '' && $curso !== '' && $profesor !== '') {
            $q3 = "SELECT id FROM aulas WHERE bloques = :bloque AND curso = :curso AND profesor = :profesor ORDER BY id DESC LIMIT 1";
            $items3 = $this->db->myPrepQuery($q3, [
                ':bloque' => $bloque,
                ':curso' => $curso,
                ':profesor' => $profesor
            ]);
            if(count($items3) > 0) return (int) $items3[0]['id'];
        }

        if($bloque !== '' && $curso !== '') {
            $q4 = "SELECT id FROM aulas WHERE bloques = :bloque AND curso = :curso ORDER BY id DESC LIMIT 1";
            $items4 = $this->db->myPrepQuery($q4, [
                ':bloque' => $bloque,
                ':curso' => $curso
            ]);
            if(count($items4) > 0) return (int) $items4[0]['id'];
        }

        return null;
    }

    public function crear($datos) {
        $this->tieneSoloLogo(); 
        $soloLogo = (int)($datos['solo_logo'] ?? 0);
        if($this->tieneColumnasDiaHora()) {
            $q = "INSERT INTO aulas (nombre, curso, dia, hora, bloques, profesor, etiqueta_codigo, antena_codigo, emparejada, solo_logo) 
                  VALUES (:nombre, :curso, :dia, :hora, :bloques, :profesor, :etiqueta_codigo, :antena_codigo, :emparejada, :solo_logo)";
            $this->db->myPrepQuery($q, [
                ':nombre' => $datos['aula'] ?? ($datos['nombre'] ?? ''),
                ':curso' => $datos['curso'] ?? '',
                ':dia' => $datos['dia'] ?? '',
                ':hora' => $datos['hora'] ?? '',
                ':bloques' => $datos['bloques'] ?? '',
                ':profesor' => $datos['profesor'] ?? '',
                ':etiqueta_codigo' => $datos['etiqueta_codigo'] ?? '',
                ':antena_codigo' => $datos['antena_codigo'] ?? '',
                ':emparejada' => $datos['emparejada'] ?? 0,
                ':solo_logo' => $soloLogo
            ]);
        } else {
            $q = "INSERT INTO aulas (nombre, curso, bloques, profesor, etiqueta_codigo, antena_codigo, emparejada, solo_logo) 
                  VALUES (:nombre, :curso, :bloques, :profesor, :etiqueta_codigo, :antena_codigo, :emparejada, :solo_logo)";
            $this->db->myPrepQuery($q, [
                ':nombre' => $datos['aula'] ?? ($datos['nombre'] ?? ''),
                ':curso' => $datos['curso'] ?? '',
                ':bloques' => $datos['bloques'] ?? '',
                ':profesor' => $datos['profesor'] ?? '',
                ':etiqueta_codigo' => $datos['etiqueta_codigo'] ?? '',
                ':antena_codigo' => $datos['antena_codigo'] ?? '',
                ':emparejada' => $datos['emparejada'] ?? 0,
                ':solo_logo' => $soloLogo
            ]);
        }
        return $this->db->getLastInsertId();
    }

    public function existeAula($datos) {
        $q = "SELECT id FROM aulas WHERE nombre = :nombre LIMIT 1";
        $items = $this->db->myPrepQuery($q, [
            ':nombre' => $datos['aula'] ?? ($datos['nombre'] ?? '')
        ]);
        return (int) count($items) > 0;
    }

    public function obtenerIdPorNombre($nombre) {
        $q = "SELECT id FROM aulas WHERE nombre = :nombre LIMIT 1";
        $items = $this->db->myPrepQuery($q, [':nombre' => $nombre]);
        return (int) count($items) > 0 ? (int)$items[0]['id'] : null;
    }

    public function actualizar($id, $datos) {
        $this->tieneSoloLogo(); 
        $soloLogo = (int)($datos['solo_logo'] ?? 0);
        if($this->tieneColumnasDiaHora()) {
            $q = "UPDATE aulas SET nombre = :nombre, curso = :curso, dia = :dia, hora = :hora, bloques = :bloques, profesor = :profesor, 
                  etiqueta_codigo = :etiqueta_codigo, antena_codigo = :antena_codigo, 
                  emparejada = :emparejada, solo_logo = :solo_logo WHERE id = :id";
            $this->db->myPrepQuery($q, [
                ':id' => $id,
                ':nombre' => $datos['aula'] ?? ($datos['nombre'] ?? ''),
                ':curso' => $datos['curso'] ?? '',
                ':dia' => $datos['dia'] ?? '',
                ':hora' => $datos['hora'] ?? '',
                ':bloques' => $datos['bloques'] ?? '',
                ':profesor' => $datos['profesor'] ?? '',
                ':etiqueta_codigo' => $datos['etiqueta_codigo'] ?? '',
                ':antena_codigo' => $datos['antena_codigo'] ?? '',
                ':emparejada' => $datos['emparejada'] ?? 0,
                ':solo_logo' => $soloLogo
            ]);
        } else {
            $q = "UPDATE aulas SET nombre = :nombre, curso = :curso, bloques = :bloques, profesor = :profesor, 
                  etiqueta_codigo = :etiqueta_codigo, antena_codigo = :antena_codigo, 
                  emparejada = :emparejada, solo_logo = :solo_logo WHERE id = :id";
            $this->db->myPrepQuery($q, [
                ':id' => $id,
                ':nombre' => $datos['aula'] ?? ($datos['nombre'] ?? ''),
                ':curso' => $datos['curso'] ?? '',
                ':bloques' => $datos['bloques'] ?? '',
                ':profesor' => $datos['profesor'] ?? '',
                ':etiqueta_codigo' => $datos['etiqueta_codigo'] ?? '',
                ':antena_codigo' => $datos['antena_codigo'] ?? '',
                ':emparejada' => $datos['emparejada'] ?? 0,
                ':solo_logo' => $soloLogo
            ]);
        }
    }

    public function eliminar($id) {
        $q = "DELETE FROM aulas WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
    }

    public function emparejar($id, $etiqueta, $antena) {
        $q = "UPDATE aulas SET etiqueta_codigo = :etiqueta, antena_codigo = :antena, emparejada = 1 WHERE id = :id";
        $this->db->myPrepQuery($q, [
            ':id' => $id,
            ':etiqueta' => $etiqueta,
            ':antena' => $antena
        ]);
    }

    public function desemparejar($id) {
        $q = "UPDATE aulas SET etiqueta_codigo = NULL, antena_codigo = NULL, emparejada = 0 WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
    }

    public function contarTotal() {
        $q = "SELECT COUNT(*) as total FROM aulas";
        $items = $this->db->myPrepQuery($q);
        return (int) $items[0]['total'];
    }

    public function contarEmparejadas() {
        $q = "SELECT COUNT(*) as total FROM aulas WHERE emparejada = 1";
        $items = $this->db->myPrepQuery($q);
        return (int) $items[0]['total'];
    }

    private function filasToAulas($items) {
        $result = [];
        foreach($items as $fila)
            $result[] = new Aula($fila);
        return $result;
    }

}//class
 