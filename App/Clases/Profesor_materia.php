<?php
class ProfesorMateria {
    private $table = 'profesor_materia'; 
    private $id_profesor;                 
    private $id_materia;                  


    public function __construct($id_profesor, $id_materia) {
        $this->id_profesor = $id_profesor; 
        $this->id_materia = $id_materia;   
    }

    public function getIdProfesor() {
        return $this->id_profesor;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }
}
?>