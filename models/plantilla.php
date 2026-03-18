<?php

//models\plantilla.php

Class Plantilla {

    private int $id;
    private string $nombre;
    private string $contenido;
    private string $created_at;

    public function __construct($data=[]) {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
        $this->contenido = $data['contenido'];
        $this->created_at = $data['created_at'] ?? '';
    }

    public function __get($name) {
        return $this->$name; 
    }

}//class
 