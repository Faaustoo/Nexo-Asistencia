<?php
namespace App\Traits;

trait ValidarRAM {

    public static function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function obtenerDatos() {
        $datos = [];
        if (isset($_POST['porcentaje_promocion'])) {
            $datos['porcentaje_promocion'] = self::clean_input($_POST['porcentaje_promocion']);
        } else {
            $datos['porcentaje_promocion'] = '';
        }

        if (isset($_POST['porcentaje_regular'])) {
            $datos['porcentaje_regular'] = self::clean_input($_POST['porcentaje_regular']);
        } else {
            $datos['porcentaje_regular'] = '';
        }

        if (isset($_POST['nota_promocion'])) {
            $datos['nota_promocion'] = self::clean_input($_POST['nota_promocion']);
        } else {
            $datos['nota_promocion'] = '';
        }

        if (isset($_POST['nota_regular'])) {
            $datos['nota_regular'] = self::clean_input($_POST['nota_regular']);
        } else {
            $datos['nota_regular'] = '';
        }

        if (isset($_POST['id_institucion'])) {
            $datos['id_institucion'] = self::clean_input($_POST['id_institucion']);
        } else {
            $datos['id_institucion'] = '';
        }
        

        return $datos;
    }

    public static function validarDatosRam($data) {
        $errores = [];
        $numeros = "/^[0-9]+(\.[0-9]+)?$/";

        if (empty($data['porcentaje_promocion'])) {
            $errores[] = "El porcentaje de promoción es obligatorio.";
        } elseif (!preg_match($numeros, $data['porcentaje_promocion']) || $data['porcentaje_promocion'] < 0 || $data['porcentaje_promocion'] > 100) {
            $errores[] = "El porcentaje de promoción debe ser un número entre 0 y 100.";
        }

        if (empty($data['porcentaje_regular'])) {
            $errores[] = "El porcentaje regular es obligatorio.";
        } elseif (!preg_match($numeros, $data['porcentaje_regular']) || $data['porcentaje_regular'] < 0 || $data['porcentaje_regular'] > 100) {
            $errores[] = "El porcentaje regular debe ser un número entre 0 y 100.";
        }

        if (empty($data['nota_promocion'])) {
            $errores[] = "La nota de promoción es obligatoria.";
        } elseif (!preg_match($numeros, $data['nota_promocion']) || $data['nota_promocion'] < 0 || $data['nota_promocion'] > 10) {
            $errores[] = "La nota de promoción debe ser un número entre 0 y 10.";
        }

        if (empty($data['nota_regular'])) {
            $errores[] = "La nota regular es obligatoria.";
        } elseif (!preg_match($numeros, $data['nota_regular']) || $data['nota_regular'] < 0 || $data['nota_regular'] > 10) {
            $errores[] = "La nota regular debe ser un número entre 0 y 10.";
        }

        if (empty($data['id_institucion'])) {
            $errores[] = "error ID.";
        } elseif (!preg_match($numeros, $data['id_institucion'])) {
            $errores[] = "Id no encontrado.";
        }


        return $errores;
    }
}

?>
