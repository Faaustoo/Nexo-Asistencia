<?php
require_once 'Persona.php';
require_once 'App\Traits\ValidarAlumno.php';

use App\Traits\ValidarAlumno;

class Alumno extends Persona {
    use ValidarAlumno;

    private static $table = 'alumnos';
    private $id_alumno;
    private $fecha_nacimiento;
    private $id_materia;

    public function __construct($nombre, $apellido, $dni, $email, $fecha_nacimiento, $id_materia) {
        parent::__construct($nombre, $apellido, $dni, $email);
        $this->fecha_nacimiento = $fecha_nacimiento; 
        $this->id_materia = $id_materia;
    }

    // Getters
    public function getIdAlumno() {
        return $this->id_alumno;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    public function getIdMateria() {
        return $this->id_materia;
    }

    // Setters
    public function setIdAlumno($id_alumno) {
        $this->id_alumno = $id_alumno;
    }

    public function setFechaNacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento; 
    }

    public function setIdMateria($id_materia) {
        $this->id_materia = $id_materia; 
    }

    public function crearAlumno($conn) {
        $query = "INSERT INTO " . self::$table . " (nombre, apellido, dni, email, fecha_nacimiento, id_materia) 
                VALUES (:nombre, :apellido, :dni, :email, :fecha_nacimiento, :id_materia)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
        $stmt->bindParam(':id_materia', $this->id_materia);
    
        if ($stmt->execute()) {
            $this->id_alumno = $conn->lastInsertId(); 
            return true; 
        }
        return false;
    }

    public function existe($data, $conn) {
        $errores = [];
        $query = "SELECT * FROM " . self::$table . " WHERE dni = :dni OR email = :email";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':dni', $data['dni']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $errores[] = "El DNI o el correo electrónico ya existen en la base de datos.";
        }
    
        return $errores;
    }

    public static function obtenerAlumnosPorMateria($id_materia, $conn) {
        $query = "SELECT * FROM alumnos WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            return false;
        }
    }

    
    public function editarAlumno($conn, $id_alumno) {
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $dni = $this->getDni();
        $email = $this->getEmail();
        $fecha_nacimiento = $this->getFechaNacimiento(); 
        $id_materia = $this->getIdMateria(); 
    
        $query = "UPDATE alumnos 
                SET nombre = :nombre, 
                    apellido = :apellido, 
                    dni = :dni, 
                    email = :email, 
                    fecha_nacimiento = :fecha_nacimiento,
                    id_materia = :id_materia
                WHERE id_alumno = :id_alumno"; 
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->bindParam(':id_alumno', $id_alumno); 
    
        return $stmt->execute();
    }
    

    public static function eliminarAlumno($id_alumno, $conn) {
        $query = "DELETE FROM " . self::$table . " WHERE id_alumno = :id_alumno"; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_alumno', $id_alumno);
        
        return $stmt->execute() && $stmt->rowCount() > 0; 
    }

    public static function dniExisteParaMateria($dni, $id_materia, $conn) {
        $query = "SELECT * FROM " . self::$table . " WHERE dni = :dni AND id_materia = :id_materia";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
    
}

?>