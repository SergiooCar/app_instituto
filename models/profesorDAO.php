<?php

/**
 * Accedo a los datos para profesores
 * 
 * @Author Alerrandro Ferreira
 * @version 1.0
 */
require_once __DIR__ . '/bd.php'; // incluir código de la clase MYDB
require_once __DIR__ . '/profesor.php'; // copia y pega el código de la clase Profesor o modelo de datos de profesores

class ProfesorDAO {
    private MyDB $db;

    public function __construct() {
        $this->db = new MyDB();
    }

    /**
     * Obtención de "profesor ordered by name"
     * 
     * retorna array de objetos Profesor
     */
    public function getAll() {//mostrar listado completo
        $q = "SELECT id, nombre, departamento, direccion_mac FROM profesores ORDER BY nombre ASC";
        $items = $this->db->myPrepQuery($q);
        return $items;
    }

    /**
     * Obtención de "profesor by id"
     * 
     * @param int $id Identificador único del profesor
     * @return Profesor/null solamente retorna un profesor si es encontrado, si no null
     */
    public function get($id) {//solamente para identificador unico por profesor
        $q = "SELECT id, nombre, departamento, direccion_mac FROM profesores WHERE id = :id";//creado por ia, es similar a plantillaDAO, no entendía lo del $q
        $items = $this->db->myPrepQuery($q, [':id' => $id]);
        
        if(count($items) == 1) {
            return new Profesor($items[0]);
        }
        return null;
    }

    /**
     * Crear o añadir un nuevo profesor a la base de datos
     * 
     * @param array $datos Datos del profesor (nombre, departamento, direccion_mac)
     * @return int ID de new profesor 
     */
    public function crear($datos) {
        $q = "INSERT INTO profesores (nombre, departamento, direccion_mac) 
              VALUES (:nombre, :departamento, :direccion_mac)";
        
        $this->db->myPrepQuery($q, [
            ':nombre' => $datos['nombre'],
            ':departamento' => $datos['departamento'] ?? null,
            ':direccion_mac' => $datos['direccion_mac'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Actualizar datos existentes
     * 
     * @param int $id ID del profesor a actualizar
     * @param array $datos Nuevos datos del profesor
     * @return bool True si se actualizó correctamente
     */
    public function actualizar($id, $datos) {
        $q = "UPDATE profesores SET 
              nombre = :nombre, 
              departamento = :departamento, 
              direccion_mac = :direccion_mac 
              WHERE id = :id";
        
        $this->db->myPrepQuery($q, [
            ':id' => $id,
            ':nombre' => $datos['nombre'],
            ':departamento' => $datos['departamento'] ?? null,
            ':direccion_mac' => $datos['direccion_mac'] ?? null
        ]);
        return true;
    }

    /**
     * Delete profesor by id
     * 
     * @param inr $id ID del profesor a eliminar
     * @return bool True si se eliminó correctamente
     */
    public function eliminar($id) {
        $q = "DELETE FROM profesores WHERE id = :id";
        $this->db->myPrepQuery($q, [':id' => $id]);
        return true;
    }
}
?>