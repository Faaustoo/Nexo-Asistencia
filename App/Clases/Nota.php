<?php

require_once 'App\Traits\ValidarNotas';

use App\Traits\ValidarNotas;

class Nota {

    use ValidarNotas;

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
        $sql = "INSERT INTO " . $this->table . " (parcial1, parcial2, trabajo_final, id_alumno, id_materia) 
            VALUES (:parcial1, :parcial2, :trabajo_final, :id_alumno, :id_materia)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':parcial1', $this->parcial1);
        $stmt->bindParam(':parcial2', $this->parcial2);
        $stmt->bindParam(':trabajo_final', $this->trabajo_final);
        $stmt->bindParam(':id_alumno', $this->id_alumno);
        $stmt->bindParam(':id_materia', $this->id_materia);

        return $stmt->execute();
    }

    public function editarNota($conn, $id_alumno, $id_materia) {
        $sql = "UPDATE " . $this->table . " 
                SET parcial1 = :parcial1, 
                    parcial2 = :parcial2, 
                    trabajo_final = :trabajo_final
                WHERE id_alumno = :id_alumno AND id_materia = :id_materia";  
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':parcial1', $this->parcial1);
        $stmt->bindParam(':parcial2', $this->parcial2);
        $stmt->bindParam(':trabajo_final', $this->trabajo_final);
        $stmt->bindParam(':id_alumno', $id_alumno);  
        $stmt->bindParam(':id_materia', $id_materia);  
        
        return $stmt->execute();  
    }
    
    

    public static function obtenerEstadosAsistenciasPorAlumno($id_materia, $conn) {
    $query = "SELECT asistencias.id_alumno, asistencias.estado AS estado_asistencia, materias.id_institucion 
            FROM asistencias
            JOIN materias ON asistencias.id_materia = materias.id_materia 
            WHERE asistencias.id_materia = :id_materia 
            ORDER BY asistencias.id_alumno";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

    
    public static function obtenerDatosCompletosPorAlumno($id_materia, $conn) {
        $query = "SELECT 
                    alumnos.id_alumno,
                    alumnos.nombre,
                    alumnos.apellido,
                    alumnos.dni,
                    notas.parcial1,
                    notas.parcial2,
                    notas.trabajo_final,
                    notas.condicion AS estado
                FROM alumnos
                INNER JOIN notas ON alumnos.id_alumno = notas.id_alumno
                WHERE notas.id_materia = :id_materia";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    

    public static function obtenerDatosRam($conn, $idInstitucion) {
        $query = "SELECT * FROM ram WHERE id_institucion = :id_institucion";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_institucion', $idInstitucion, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
    

?>
