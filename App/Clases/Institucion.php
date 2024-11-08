<?php
require_once 'App\Traits\ValidarInstitucion.php';

use App\Traits\ValidarInstitucion;

class Institucion {

    use ValidarInstitucion;
    
    private static $table = 'instituciones';
    private $id_institucion;           
    private $nombre;                 
    private $direccion;   
    private $cue;     
    private $id_profesor; 
    

    public function __construct($nombre, $direccion, $cue, $id_profesor) {
        $this->nombre = $nombre;         
        $this->direccion = $direccion;
        $this->cue = $cue; 
        $this->id_profesor = $id_profesor; 
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

    public function getCue() {
        return $this->cue;
    }

    
    public function getIdProfesor() {
        return $this->id_profesor; 
    }


    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setIdInstitucion($id_institucion) {
    $this->id_institucion = $id_institucion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setCue($cue) {
        $this->cue = $cue;
    }

    public function setIdProfesor($id_profesor){
        $this->id_profesor = $id_profesor;
    }

    public function crearInstitucion($conn) {
        $nombre = $this->getNombre();
        $direccion = $this->getDireccion();
        $cue = $this->getCue();
        $id_profesor = $this->getIdProfesor(); 
    
        
        $query = "INSERT INTO " .self::$table . " (nombre, direccion, cue, id_profesor) 
                VALUES (:nombre, :direccion, :cue, :id_profesor)";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':cue', $cue);
        $stmt->bindParam(':id_profesor', $id_profesor);
        
        if ($stmt->execute()) {
            $this->id_institucion = $conn->lastInsertId();
            return true;
        }
        return false;
    }
    
    public static function obtenerInstitucionesPorProfesor($conn, $id_profesor) {
        $query = "SELECT * FROM " . self::$table . " WHERE id_profesor = :id_profesor";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_profesor', $id_profesor, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function eliminarInstitucion($conn, $nombre, $id_profesor) {
        $sql = "DELETE FROM " . self::$table . " WHERE nombre = :nombre AND id_profesor = :id_profesor"; 
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':id_profesor', $id_profesor, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
    
}
?>