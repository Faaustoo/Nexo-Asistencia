<?php
namespace App\Traits;

trait ValidarInstitucion {
    
    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function obtenerDatos() {
        $datos = [];
        if (isset($_POST['nombre_institucion'])) {
            $datos['nombre_institucion'] = $this->clean_input($_POST['nombre_institucion']);
        } else {
            $datos['nombre_institucion'] = '';
        }

        if (isset($_POST['direccion_institucion'])) {
            $datos['direccion_institucion'] = $this->clean_input($_POST['direccion_institucion']);
        } else {
            $datos['direccion_institucion'] = '';
        }

        if (isset($_POST['cue_institucion'])) {
            $datos['cue_institucion'] = $this->clean_input($_POST['cue_institucion']);
        } else {
            $datos['cue_institucion'] = '';
        }

        return $datos;
    }

    public function validarDatos($data) {
        $errores = [];

        $letrasEspaciosNumeros = "/^[a-zA-Z0-9\s]+$/";
        $letrasEspacios = "/^[a-zA-Z\s]+$/";
        $numeros = "/^[0-9]+$/";

        if (empty($data['nombre_institucion'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (!preg_match($letrasEspacios, $data['nombre_institucion'])) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }

        if (empty($data['direccion_institucion'])) {
            $errores[] = "La direccion es obligatoria.";
        } elseif (!preg_match($letrasEspaciosNumeros, $data['direccion_institucion'])) {
            $errores[] = "la direccion solo puede contener letras,espacios y numeros.";
        }

        if (empty($data['cue_institucion'])) {
            $errores[] = "El cue es obligatorio.";
        } elseif (!preg_match($numeros, $data['cue_institucion'])) {
            $errores[] = "El cue solo puede contener numeros.";
        }
        return $errores;
    }

    public function obtenerDatosEliminar() {
        $datos = [];
        if (isset($_POST['nombre_institucion'])) {
            $datos['nombre_institucion'] = $this->clean_input($_POST['nombre_institucion']);
        } else {
            $datos['nombre_institucion'] = '';
        }
        
        return $datos; 
    }
    
    public function validarDatosEliminar($data) {
        $letrasEspacios = "/^[a-zA-Z\s]+$/";
        $errores = []; 
        
        if (empty($data['nombre_institucion'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (!preg_match($letrasEspacios, $data['nombre_institucion'])) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }
    
        return $errores; 
    }
    
}    

