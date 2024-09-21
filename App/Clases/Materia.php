<?php
class Materia {
    private $table = 'materias';
    private $id_materia;
    private $nombre;
    private $descripcion; 
    private $id_institucion;

    public function __construct($nombre, $descripcion, $id_institucion) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion; 
        $this->id_institucion = $id_institucion;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() { 
        return $this->descripcion;
    }

    public function getIdInstitucion() {
        return $this->id_institucion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion;
    }

    public function crearMateria($conn) {
        $nombre = $this->getNombre();
        $descripcion = $this->getDescripcion();

        $query = "INSERT INTO " . $this->table . " (nombre, descripcion, id_institucion) 
                  VALUES (:nombre, :descripcion, :id_institucion)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id_institucion', $this->id_institucion); 
        return $stmt->execute();
    }

    public function obtenerMaterias($conn) {
        $query = "SELECT * FROM " . $this->table; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function actualizarMateria($conn, $id_materia) {
        $nombre = $this->getNombre();
        $descripcion = $this->getDescripcion();

        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, descripcion = :descripcion 
                  WHERE id_materia = :id_materia";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id_materia', $id_materia);
        
        return $stmt->execute();
    }

    public function eliminarMateria($conn, $id_materia) {
        $query = "DELETE FROM " . $this->table . " WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materia', $id_materia);
        
        return $stmt->execute();
    }
}
?>
