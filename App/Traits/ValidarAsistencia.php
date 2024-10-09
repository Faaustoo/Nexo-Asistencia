<?php 

namespace App\Traits;

trait ValidarAsistencia {
    

    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function obtenerFechaEliminar() {
        $datos = [];
        if (isset($_POST['fecha'])) {
            $datos['fecha'] = $this->clean_input($_POST['fecha']);
        } else {
            $datos['fecha'] = '';
        }
        return $datos; 
    }

    public function validarFechaEliminar($data) {
        $errores = []; // Inicializar el array de errores
        $fechaPattern = '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';

        if (empty($data['fecha'])) {
            $errores[] = "La fecha es obligatoria.";
        } elseif (!preg_match($fechaPattern, $data['fecha'])) {
            $errores[] = "El formato de la fecha no es válido. Debe ser YYYY-MM-DD.";
        }

        return $errores; 
    }
}
