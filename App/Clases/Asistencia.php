<?php
require_once 'App\Traits\ValidarAsistencia.php';

 use   App\Traits\ValidarAsistencia;
     
class Asistencia {

    use ValidarAsistencia;

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
        $fecha = $this->getFecha();
        $estado = $this->getEstado();
        $id_alumno = $this->getIdAlumno();
        $id_materia = $this->getIdMateria();

        // Consulta para insertar un nuevo registro de asistencia
        $query = "INSERT INTO asistencias (fecha, estado, id_alumno, id_materia) 
                VALUES (:fecha, :estado, :id_alumno, :id_materia)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_alumno', $id_alumno);
        $stmt->bindParam(':id_materia', $id_materia);
        
    
        if ($stmt->execute()) {
            $this->id_asistencia = $conn->lastInsertId(); 
            return true; 
        }
        return false; 
    }
    

    public function existeAsistencia($conn, $fecha) {
        $query = "SELECT COUNT(*) as total FROM asistencias WHERE fecha = :fecha";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna true si existen registros, false si no hay
        return $resultado['total'] > 0;
    }

    // Función para eliminar asistencia por fecha
    public function eliminarAsistencia($conn, $fecha) {
        $query = "DELETE FROM asistencias WHERE fecha = :fecha";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);

        if ($stmt->execute()) {
            return $stmt->rowCount(); // Retorna el número de filas eliminadas
        }
        return false; // Si hubo un error al eliminar
    }
    
}
?>