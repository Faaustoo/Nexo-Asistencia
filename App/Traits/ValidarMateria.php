<?php
namespace App\Traits;

trait ValidarMateria {
    
    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function obtenerDatos() {
        $datos = [];
        
        if (isset($_POST['nombre_materia'])) {
            $datos['nombre_materia'] = $this->clean_input($_POST['nombre_materia']);
        } else {
            $datos['nombre_materia'] = '';
        }

        if (isset($_POST['id_institucion'])) {
            $datos['id_institucion'] = $this->clean_input($_POST['id_institucion']);
        } else {
            $datos['id_institucion'] = '';
        }

        return $datos;
    }

    public function validarDatos($data) {
        $errores = [];
        $letrasEspaciosNumeros = "/^[a-zA-Z0-9\s]+$/";
        $numeros = "/^[0-9]+$/";

        if (empty($data['nombre_materia'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (!preg_match($letrasEspaciosNumeros, $data['nombre_materia'])) {
            $errores[] = "El nombre solo puede contener letras, espacios y números.";
        }

        if (empty($data['id_institucion'])) {
            $errores[] = "El ID de la institución no se encuentra.";
        } elseif (!preg_match($numeros, $data['id_institucion'])) {
            $errores[] = "El ID de la institución solo puede ser numérico.";
        }

        return $errores;
    }

    public function obtenerDatosEliminar() {
        $datos = [];
        if (isset($_POST['nombre_materia'])) {
            $datos['nombre_materia'] = $this->clean_input($_POST['nombre_materia']);
        } else {
            $datos['nombre_materia'] = '';
        }
        
        return $datos; 
    }
    
    public function validarDatosEliminar($data) {
        $letrasEspaciosNumeros = "/^[a-zA-Z0-9\s]+$/";
        $errores = []; 
        
        if (empty($data['nombre_materia'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (!preg_match($letrasEspaciosNumeros, $data['nombre_materia'])) {
            $errores[] = "El nombre solo puede contener letras, espacios y números.";
        }
    
        return $errores; 
    }
}
?>