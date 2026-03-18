<?php

//models\horario.php

Class Horario {

    private int $id;
    private int $aula_id;
    private string $dia;
    private string $hora_inicio;
    private string $hora_fin;
    private string $bloque;
    private string $profesor;
    private string $curso;

    public function __construct($data=[]) {
        $this->id = $data['id'] ?? 0;
        $this->aula_id = $data['aula_id'] ?? 0;
        $this->dia = $data['dia'] ?? '';
        $this->hora_inicio = $data['hora_inicio'] ?? '';
        $this->hora_fin = $data['hora_fin'] ?? '';
        $this->bloque = $data['bloque'] ?? '';
        $this->profesor = $data['profesor'] ?? '';
        $this->curso = $data['curso'] ?? '';
    }

    public function __get($name) {
        return $this->$name; 
    }

}//class
 