<?php 
namespace App\Traits;

use DateTime;

trait ValidarAlumno {

    public static function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function obtenerDatos() {
        $datos = [];

        if (isset($_POST['nombre'])) {
            $datos['nombre'] = self::clean_input($_POST['nombre']);
        } else {
            $datos['nombre'] = '';
        }

        if (isset($_POST['apellido'])) {
            $datos['apellido'] = self::clean_input($_POST['apellido']);
        } else {
            $datos['apellido'] = '';
        }

        if (isset($_POST['dni'])) {
            $datos['dni'] = self::clean_input($_POST['dni']);
        } else {
            $datos['dni'] = '';
        }

        if (isset($_POST['email'])) {
            $datos['email'] = self::clean_input($_POST['email']);
        } else {
            $datos['email'] = '';
        }

        if (isset($_POST['fecha_nacimiento'])) {
            $datos['fecha_nacimiento'] = self::clean_input($_POST['fecha_nacimiento']);
        } else {
            $datos['fecha_nacimiento'] = '';
        }

        if (isset($_POST['id_materia'])) {
            $datos['id_materia'] = self::clean_input($_POST['id_materia']);
        } else {
            $datos['id_materia'] = '';
        }
        
        return $datos;
    }

    public static function validarDatos($data) {
        $errores = [];
    
        // Expresiones regulares para validación
        $numeros = "/^\d+$/";
        $email = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
        $letrasEspacios = "/^[a-zA-Z\s]+$/";
        $fecha = '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
    
        if (empty($data['nombre'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (!preg_match($letrasEspacios, $data['nombre'])) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }
    
        if (empty($data['apellido'])) {
            $errores[] = "El apellido es obligatorio.";
        } elseif (!preg_match($letrasEspacios, $data['apellido'])) {
            $errores[] = "El apellido solo puede contener letras y espacios.";
        }
    
        if (empty($data['dni'])) {
            $errores[] = "El DNI es obligatorio.";
        } elseif (!preg_match($numeros, $data['dni'])) {
            $errores[] = "El DNI solo puede contener números.";
        }
        
        if (empty($data['email'])) {
            $errores[] = "El correo es obligatorio.";
        } elseif (!preg_match($email, $data['email'])) {
            $errores[] = "El formato del correo no es válido.";
        }
    
        if (empty($data['fecha_nacimiento'])) {
            $errores[] = "La fecha de nacimiento es obligatoria.";
        } elseif (!preg_match($fecha, $data['fecha_nacimiento'])) {
            $errores[] = "El formato de la fecha no es válido. Debe ser YYYY-MM-DD.";
        } else {
            
            $fecha_nacimiento = new DateTime($data['fecha_nacimiento']);
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento)->y;  
            
            if ($edad < 18) {
                $errores[] = "Debe tener al menos 18 años.";
            } elseif ($edad > 80) {
                $errores[] = "Debe ser menor de 80 años.";
            }
        }
    
        if (empty($data['id_materia'])) {
            $errores[] = "El ID de materia es obligatorio.";
        } elseif (!preg_match($numeros, $data['id_materia'])) {
            $errores[] = "El ID solo puede contener números.";
        }
    
        return $errores;
    }
    
    public static function obtenerDatosEliminar() {
        $datos = [];
        if (isset($_POST['id_alumno'])) {
            $datos['id_alumno'] = self::clean_input($_POST['id_alumno']);
        } else {
            $datos['id_alumno'] = '';
        }
        
        return $datos; 
    }

}
?>


