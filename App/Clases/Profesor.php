<?php
require_once 'Persona.php';
require_once 'App\Traits\Validaciones.php';

use App\Traits\Validaciones;


class Profesor extends Persona {
    use Validaciones; 

    private $table = 'profesores';
    private $id_profesor;
    private $contrasena;
    private $numero_legajo;

    public function __construct($nombre, $apellido, $dni, $email, $contrasena, $numero_legajo) {
        parent::__construct($nombre, $apellido, $dni, $email);
        $this->contrasena = $contrasena;
        $this->numero_legajo = $numero_legajo;
    }

    public function getIdProfesor(){
        return $this->id_profesor;
    }

    public function getNumeroLegajo(){
        return $this->numero_legajo;
    }

    public function setContrasena($contrasena){
        $this->contrasena= $contrasena;
    }

    public function setNumeroLegajo($numero_legajo){
        $this->numero_legajo= $numero_legajo;
    }

    public function setIdProfesor($id_profesor){
        $this->id_profesor = $id_profesor;
    }

    public function create($conn) {
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $dni = $this->getDni();
        $email = $this->getEmail();
        $contrasenaHash = password_hash($this->contrasena, PASSWORD_BCRYPT);
        $numero_legajo = $this->getNumeroLegajo();

        $query = "INSERT INTO " . $this->table . " (nombre, apellido, dni, email, contrasena, numero_legajo) 
                VALUES (:nombre, :apellido, :dni, :email, :contrasena, :numero_legajo)";
    
        $stmt = $conn->prepare($query);
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $contrasenaHash); 
        $stmt->bindParam(':numero_legajo', $numero_legajo);
    
        if ($stmt->execute()) {
            $this->id_profesor = $conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function obtenerProfesores($conn) {
        $query = "SELECT * FROM " . $this->table; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    
public function actualizarProfesor($conn, $id_profesor) {
    $nombre = $this->getNombre();
    $apellido = $this->getApellido();
    $dni = $this->getDni();
    $email = $this->getEmail();
    $numero_legajo = $this->getNumeroLegajo();

    $query = "UPDATE " . $this->table . " 
            SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email, numero_legajo = :numero_legajo 
            WHERE id_profesor = :id_profesor";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':numero_legajo', $numero_legajo);
    $stmt->bindParam(':id_profesor', $id_profesor);

    return $stmt->execute();
    }

    public function eliminarProfesor($conn, $id_profesor) {
        $query = "DELETE FROM " . $this->table . " WHERE id_profesor = :id_profesor";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_profesor', $id_profesor);
        
        return $stmt->execute();
    }
    
    public function existe($data, $conn) {
        $errores = [];
    
        $query = "SELECT * FROM profesores WHERE dni = :dni";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':dni', $data['dni']);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    
        if ($stmt->rowCount() > 0) {
            $errores[] = "El DNI ya existe.";
        }
    
    
        $query = "SELECT * FROM profesores WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $errores[] = "El correo electrónico ya existe.";
        }
    
        $query = "SELECT * FROM profesores WHERE numero_legajo = :numero_legajo";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':numero_legajo', $data['numero_legajo']);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $errores[] = "El número de legajo ya existe.";
        }
    
        return $errores;
    }

    public function validarLogin($email, $contrasena, $profesores) {
        foreach ($profesores as $profesor) {
            if ($profesor['email'] === $email) {
                if (password_verify($contrasena, $profesor['contrasena'])) {
                    return [
                        'id_profesor' => $profesor['id_profesor'], 
                        'apellido' => $profesor['apellido'],
                        'dni' => $profesor['dni'],
                        'email' => $profesor['email'],
                        'legajo' => $profesor['numero_legajo'],
                    ];
                }
            }
        }
        return null; 
    }
    
}
?>