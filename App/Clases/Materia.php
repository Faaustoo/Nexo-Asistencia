<?php
require_once 'App\Traits\ValidarMateria.php';

use App\Traits\ValidarMateria;

class Materia {
    use ValidarMateria; 
    
    private static $table = 'materias';
    private $id_materia;
    private $nombre;
    private $id_institucion;

    public function __construct($nombre , $id_institucion) {
        $this->nombre = $nombre;
        $this->id_institucion = $id_institucion;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getIdInstitucion() {
        return $this->id_institucion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setIdInstitucion($id_institucion) {
        $this->id_institucion = $id_institucion;
    }

    public function crearMateria($conn) {
        $nombre = $this->getNombre();
        $id_institucion = $this->getIdInstitucion();
    
        $query = "INSERT INTO " . self::$table . " (nombre, id_institucion) 
                VALUES (:nombre, :id_institucion)";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id_institucion', $id_institucion);
        return $stmt->execute(); 
    }
    
    public static function obtenerMateriasPorInstitucion($conn, $id_institucion) {
        $query = "SELECT m.id_materia, m.nombre 
                FROM " . self::$table . " m 
                INNER JOIN instituciones i ON m.id_institucion = i.id_institucion 
                WHERE m.id_institucion = :id_institucion";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_institucion', $id_institucion, PDO::PARAM_INT); 
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public static function eliminarMateria($conn, $nombre, $id_institucion) {
        $sql = "DELETE FROM " . self::$table . " WHERE nombre = :nombre AND id_institucion = :id_institucion";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':id_institucion', $id_institucion, PDO::PARAM_INT);
        
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    }
    
}
?>