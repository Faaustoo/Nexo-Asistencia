<?php
require_once 'Persona.php';

require_once 'App\Traits\ValidarAlumno.php';

use App\Traits\ValidarAlumno;


class Alumno extends Persona {

    use ValidarAlumno;
    
    private $table = 'alumnos';
    private $id_alumno;
    private $fecha_nacimiento;
    private $id_materia;

    public function __construct($nombre, $apellido, $dni, $email, $fecha_nacimiento, $id_materia) {
        parent::__construct($nombre, $apellido, $dni, $email);
        $this->fecha_nacimiento = $fecha_nacimiento; 
        $this->id_materia = $id_materia;
    }

    public function getIdAlumno() {
        return $this->id_alumno;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre; 
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido; 
    }
    public function setDni($dni) {
        $this->dni = $dni; 
    }
    public function setEmail($email) {
        $this->email = $email; 
    }

    public function setFechaNacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento; 
    }

    public function setIdMateria($id_materia) {
        $this->id_materia = $id_materia; 
    }

    public function crearAlumno($conn) {
        
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $dni = $this->getDni();
        $email = $this->getEmail();
        $fecha_nacimiento = $this->getFechaNacimiento();
        $id_materia = $this->getIdMateria();

        $query = "INSERT INTO alumnos (nombre, apellido, dni, email, fecha_nacimiento, id_materia) 
                VALUES (:nombre, :apellido, :dni, :email, :fecha_nacimiento, :id_materia)";
        
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':id_materia', $id_materia);
    
    
        if ($stmt->execute()) {
            $this->id_alumno = $conn->lastInsertId(); 
            return true; 
        }
        return false;
    }

    public function existe($data, $conn) {
        $errores = [];
    
        $query = "SELECT * FROM alumnos WHERE dni = :dni OR email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':dni', $data['dni']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $errores[] = "El DNI o el correo electrónico ya existen en la base de datos.";
        }
    
        return $errores;
    }

    public function obtenerAlumnosPorMateria($id_materia, $conn) {
        $query = "SELECT * FROM alumnos WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
}


