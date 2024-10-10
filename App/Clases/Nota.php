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

    public function insertarNota($conn) {
        $query = "INSERT INTO $this->table (parcial1, parcial2, trabajo_final, id_alumno, id_materia) 
                  VALUES (:parcial1, :parcial2, :trabajo_final, :id_alumno, :id_materia)";
        
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':parcial1', $this->parcial1);
        $stmt->bindParam(':parcial2', $this->parcial2);
        $stmt->bindParam(':trabajo_final', $this->trabajo_final);
        $stmt->bindParam(':id_alumno', $this->id_alumno);
        $stmt->bindParam(':id_materia', $this->id_materia);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerDatosAlumnos($id_materia, $conn) {
        $query = "SELECT 
                    alumnos.id_alumno,
                    alumnos.nombre,
                    alumnos.apellido,
                    alumnos.dni,
                    alumnos.email,
                    notas.parcial1,
                    notas.parcial2,
                    notas.trabajo_final
                    FROM 
                        alumnos
                    LEFT JOIN 
                        notas ON alumnos.id_alumno = notas.id_alumno 
                    AND notas.id_materia = :id_materia";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function obtenerEstadosAsistenciasPorAlumno($id_materia, $conn) {
        $query = "SELECT 
                    asistencias.id_alumno, 
                    asistencias.estado AS estado_asistencia 
                    FROM 
                    asistencias 
                    WHERE 
                    asistencias.id_materia = :id_materia 
                    ORDER BY 
                    asistencias.id_alumno"; 
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $stmt->execute();
        
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

}
?>