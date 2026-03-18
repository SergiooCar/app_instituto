<?php

//models\aula.php

Class Aula {

    private int $id;
    private string $aula;
    private string $nombre;
    private string $curso;
    private string $dia;
    private string $hora;
    private string $bloques;
    private string $profesor;
    private string $etiqueta_codigo;
    private string $antena_codigo;
    private int $emparejada;
    private int $solo_logo;

    public function __construct($data=[]) {
        $this->id = $data['id'];
        $valorAula = $data['aula'] ?? ($data['nombre'] ?? '');
        $this->aula = $valorAula;
        $this->nombre = $valorAula;
        $this->curso = $data['curso'] ?? '';
        $this->dia = $data['dia'] ?? '';
        $this->hora = $data['hora'] ?? '';
        $this->bloques = $data['bloques'] ?? '';
        $this->profesor = $data['profesor'] ?? '';
        $this->etiqueta_codigo = $data['etiqueta_codigo'] ?? '';
        $this->antena_codigo = $data['antena_codigo'] ?? '';
        $this->emparejada = $data['emparejada'] ?? 0;
        $this->solo_logo = (int)($data['solo_logo'] ?? 0);
    }

    public function __get($name) {
        if($name === 'aula') return $this->aula;
        if($name === 'nombre') return $this->nombre;
        return $this->$name; 
    }

}//class
 