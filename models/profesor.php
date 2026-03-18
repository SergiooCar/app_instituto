<?php
/**
 * Es un modelo entidad que representa la tabla de profesores en la base de datos
 * 
 * @Author Sergio Carchipulla
 * @version 1.0
 */
Class Profesor{
    private int $id;
    private string $nombre;
    private string $departamento;
    private string $direccion_mac;

    function getId(): int {
        return $this->id;
    }

    function getNombre(): string {
        return $this->nombre;
    }

    function getDepartamento(): string {
        return $this->departamento;
    }

    function getDireccionMac(): string {
        return $this->direccion_mac;
    }
}

?>