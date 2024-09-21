<?php
class Institucion {
    private $table = 'instituciones'; 
    private $id_institucion;           
    private $nombre;                 
    private $direccion;              
    
    public function __construct($nombre, $direccion) {
        $this->nombre = $nombre;         
        $this->direccion = $direccion;  
    }

    public function getIdInstitucion() {
        return $this->id_institucion;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function create($db) {
        $nombre = $this->getNombre();
        $direccion = $this->getDireccion();

        $query = "INSERT INTO " . $this->table . " (nombre, direccion)";
    
        $stmt = $db->prepare($query);
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        if ($stmt->execute()) {
            $this->id_institucion = $db->lastInsertId();
            return true;
        }
        return false;
    }
}
?>