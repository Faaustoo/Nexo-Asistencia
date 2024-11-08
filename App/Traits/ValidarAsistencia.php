<?php 

namespace App\Traits;

trait ValidarAsistencia {
    
    public static function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function obtenerEliminar() {
        $datos = [];
        if (isset($_POST['fecha'])) {
            $datos['fecha'] = self::clean_input($_POST['fecha']);
        } else {
            $datos['fecha'] = '';
        }
        if (isset($_POST['id'])) {
            $datos['id'] = self::clean_input($_POST['id']);
        } else {
            $datos['id'] = '';
        }
        return $datos; 
    }

    public static function validarEliminar($data) {
        $errores = []; 
        $fecha= '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
        $numeros = "/^[0-9]+$/";

        if (empty($data['fecha'])) {
            $errores[] = "La fecha es obligatoria ";
        } elseif (!preg_match($fecha, $data['fecha'])) {
            $errores[] = "El formato de la fecha no es válido. Debe ser YYYY-MM-DD.";
        }

        if (empty($data['id'])) {
            $errores[] = "ID obligatorio.";
        } elseif (!preg_match($numeros, $data['id'])) {
            $errores[] = "El ID debe ser un numero.";
        }

        return $errores; 
    }
}
