<?php 
namespace App\Traits;

trait ValidarAlumno {
    
    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function obtenerDatos() {
        $datos = [];

        if (isset($_POST['nombre'])) {
            $datos['nombre'] = $this->clean_input($_POST['nombre']);
        } else {
            $datos['nombre'] = '';
        }

        if (isset($_POST['apellido'])) {
            $datos['apellido'] = $this->clean_input($_POST['apellido']);
        } else {
            $datos['apellido'] = '';
        }

        if (isset($_POST['dni'])) {
            $datos['dni'] = $this->clean_input($_POST['dni']);
        } else {
            $datos['dni'] = '';
        }

        if (isset($_POST['email'])) {
            $datos['email'] = $this->clean_input($_POST['email']);
        } else {
            $datos['email'] = '';
        }

        if (isset($_POST['fecha_nacimiento'])) {
            $datos['fecha_nacimiento'] = $this->clean_input($_POST['fecha_nacimiento']);
        } else {
            $datos['fecha_nacimiento'] = '';
        }

        if (isset($_POST['id_materia'])) {
            $datos['id_materia'] = $this->clean_input($_POST['id_materia']);
        } else {
            $datos['id_materia'] = '';
        }
        
        
        return $datos;
    }

    public function validarDatos($data) {
        $errores = [];
    
        // Expresiones regulares para validación
        $numeros = "/^\d+$/";
        $email = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
        $letrasEspacios = "/^[a-zA-Z\s]+$/";
        $fecha = '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
    
        // Validación del nombre
        if (empty($data['nombre'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (!preg_match($letrasEspacios, $data['nombre'])) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }
    
        // Validación del apellido
        if (empty($data['apellido'])) {
            $errores[] = "El apellido es obligatorio.";
        } elseif (!preg_match($letrasEspacios, $data['apellido'])) {
            $errores[] = "El apellido solo puede contener letras y espacios.";
        }
    
        // Validación del DNI
        if (empty($data['dni'])) {
            $errores[] = "El DNI es obligatorio.";
        } elseif (!preg_match($numeros, $data['dni'])) {
            $errores[] = "El DNI solo puede contener números.";
        }
        
        // Validación del correo electrónico
        if (empty($data['email'])) {
            $errores[] = "El correo es obligatorio.";
        } elseif (!preg_match($email, $data['email'])) {
            $errores[] = "El formato del correo no es válido.";
        }
    
        // Validación de la fecha de nacimiento
        if (empty($data['fecha_nacimiento'])) {
            $errores[] = "La fecha de nacimiento es obligatoria.";
        } elseif (!preg_match($fecha, $data['fecha_nacimiento'])) {
            $errores[] = "El formato de la fecha no es válido. Debe ser YYYY-MM-DD.";
        }
    
        // Validación del ID de materia
        if (empty($data['id_materia'])) {
            $errores[] = "El ID de materia es obligatorio.";
        } elseif (!preg_match($numeros, $data['id_materia'])) {
            $errores[] = "El ID solo puede contener números.";
        }
    
        return $errores;
    }
    
}
?>
