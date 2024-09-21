<?php
class Nota {
    private $table = 'notas';
    private $id_nota;
    private $parcial1;
    private $parcial2;
    private $trabajo_final;
    private $id_alumno;
    private $id_materia;

    public function __construct($parcial1, $parcial2, $trabajo_final, $id_alumno, $id_materia) {     
        $this->parcial1 = $parcial1;             
        $this->parcial2 = $parcial2;             
        $this->trabajo_final = $trabajo_final;   
        $this->id_alumno = $id_alumno;          
        $this->id_materia = $id_materia;     
    }

    public function getIdNota() {
        return $this->id_nota;
    }

    public function getParcial1() {
        return $this->parcial1;
    }

    public function getParcial2() {
        return $this->parcial2;
    }

    public function getTrabajoFinal() {
        return $this->trabajo_final;
    }

    public function getIdAlumno() {
        return $this->id_alumno;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }

    public function setParcial1($parcial1) {
        $this->parcial1 = $parcial1;
    }
    

    public function setParcial2($parcial2) {
        $this->parcial2 = $parcial2;
    }

    public function setTrabajoFinal($trabajo_final) {
        $this->trabajo_final = $trabajo_final;
    }

}
?>