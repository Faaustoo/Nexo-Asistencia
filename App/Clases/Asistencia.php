<?php
require_once 'App\Traits\ValidarAsistencia.php';

 use   App\Traits\ValidarAsistencia;
     
class Asistencia {

    use ValidarAsistencia;

    private static $table = 'asistencias';
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

    public function setIdAsistencia($id_asistencia) {
        $this->id_asistencia = $id_asistencia;
    }
    public function setIdAlumno($id_alumno) {
        $this->id_alumno = $id_alumno;
    }
    public function setIdMateria($id_materia) {
        $this->id_materia= $id_materia;
    }

    public function setFecha($fecha) {
        return $this->fecha= $fecha;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function crearAsistencia($conn) {
        $query = "INSERT INTO " . self::$table . " (fecha, estado, id_alumno, id_materia) 
                VALUES (:fecha, :estado, :id_alumno, :id_materia)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':id_alumno', $this->id_alumno);
        $stmt->bindParam(':id_materia', $this->id_materia);
        
        if ($stmt->execute()) {
            return $conn->lastInsertId(); 
        }
        return false; 
    }
    

    public static function existeAsistencia($conn, $fecha, $id_alumno) {
        $query = "SELECT estado FROM asistencias WHERE fecha = :fecha AND id_alumno = :id_alumno"; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_alumno', $id_alumno);
        $stmt->execute();
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado && $resultado['estado'] == 1) {
            return true; 
        }
        return false; 
    }
    
    public static function actualizarAsistencia($conn, $fecha, $id_alumno) {
        $query = "UPDATE asistencias SET estado = 0 WHERE fecha = :fecha AND id_alumno = :id_alumno AND estado = 1"; // Cambia 'dni' por 'id_alumno'
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_alumno', $id_alumno); 
        $stmt->execute();
        
        $rowCount = $stmt->rowCount(); 
        return $rowCount > 0; 
    }
    
    public static function existeAsistenciaProfesor($conn, $fecha, $id_materia) {
        
        $query = "SELECT COUNT(*) FROM asistencias WHERE fecha = :fecha AND id_materia = :id_materia";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_materia', $id_materia); 
        $stmt->execute();
        
        $count = $stmt->fetchColumn(); 

        return $count > 0;
    }
    
    
    
    
    
}
?>