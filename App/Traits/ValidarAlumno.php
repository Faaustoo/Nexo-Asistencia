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
        
        return $datos;
    }

    public function validarDatos($data) {
        $errores = [];

        $numeros = "/^\d+$/";
        $email = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
        $letrasEspacios = "/^[a-zA-Z\s]+$/";

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

        return $errores;
    }
}
?>
