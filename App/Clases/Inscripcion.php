<?php
class Inscripcion {
    private $table = 'inscripciones';
    private $id_inscripcion;
    private $id_alumno;
    private $id_materia;

    public function __construct($id_alumno, $id_materia) {
        $this->id_alumno = $id_alumno;
        $this->id_materia = $id_materia;
    }

    public function getIdInscripcion() {
        return $this->id_inscripcion; 
    }

    public function getIdAlumno() {
        return $this->id_alumno;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }
}

?>