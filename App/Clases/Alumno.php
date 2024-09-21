<?php
require_once 'Persona.php';

class Alumno extends Persona {
    private $table = 'alumnos';
    private $id_alumno;
    private $fecha_nacimiento;
    private $id_institucion;

    public function __construct($nombre, $apellido, $dni, $email, $fecha_nacimiento, $id_institucion) {
        parent::__construct($nombre, $apellido, $dni, $email);
        $this->fecha_nacimiento = $fecha_nacimiento; 
        $this->id_institucion = $id_institucion;
    }

    public function getIdAlumno() {
        return $this->id_alumno;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    public function getIdInstitucion() {
        return $this->id_institucion;
    }

    public function setFechaNacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento; 
    }

    public function crearAlumno($conn) {
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $dni = $this->getDni();
        $email = $this->getEmail();
        $fecha_nacimiento = $this->getFechaNacimiento();
        $id_institucion = $this->getIdInstitucion();

        $query = "INSERT INTO " . $this->table . " (nombre, apellido, dni, email, fecha_nacimiento, id_institucion) 
                VALUES (:nombre, :apellido, :dni, :email, :fecha_nacimiento, :id_institucion)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':id_institucion', $id_institucion); 
        
        return $stmt->execute();
    }

    public function obtenerAlumnos($conn) {
        $query = "SELECT * FROM " . $this->table; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function actualizarAlumno($conn, $id_alumno) {
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $dni = $this->getDni();
        $email = $this->getEmail();
        $fecha_nacimiento = $this->getFechaNacimiento();
        $id_institucion = $this->getIdInstitucion();

        $query = "UPDATE " . $this->table . " 
                SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email, 
                fecha_nacimiento = :fecha_nacimiento, id_institucion = :id_institucion 
                WHERE id_alumno = :id_alumno";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':id_institucion', $id_institucion);
        $stmt->bindParam(':id_alumno', $id_alumno);
        
        return $stmt->execute();
    }

    public function eliminarAlumno($conn, $id_alumno) {
        $query = "DELETE FROM " . $this->table . " WHERE id_alumno = :id_alumno";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_alumno', $id_alumno);
        
        return $stmt->execute();
    }
}


