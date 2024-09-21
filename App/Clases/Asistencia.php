<?php
class Asistencia {
    private $table = 'asistencias';
    private $id_asistencia; 
    private $id_alumno;    
    private $id_materia;   
    private $fecha;        
    private $estado;        

    public function __construct($fecha, $estado, $id_alumno, $id_materia) {
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->id_alumno = $id_alumno;
        $this->id_materia = $id_materia;
    }

    public function getIdAsistencia() {
        return $this->id_asistencia;
    }

    public function getIdAlumno() {
        return $this->id_alumno;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}
?>