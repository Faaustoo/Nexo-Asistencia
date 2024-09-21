<?php
class ProfesorInstituto {
    private $table = 'profesor_instituto';
    private $id_profesor;
    private $id_institucion;

    public function __construct($id_profesor, $id_institucion) {
        $this->id_profesor = $id_profesor;
        $this->id_institucion = $id_institucion;
    }

    public function getIdProfesor() {
        return $this->id_profesor;
    }

    public function getIdInstitucion() {
        return $this->id_institucion;
    }
}
?>