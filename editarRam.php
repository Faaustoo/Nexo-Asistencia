<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if (isset($_SESSION['id_profesor'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $datos = Ram::obtenerDatos();
        $errores = Ram::validarDatosRam($datos);
        
        if (empty($errores)) {
            $ram = new Ram($datos['porcentaje_promocion'],$datos['porcentaje_regular'],$datos['nota_promocion'],$datos['nota_regular'],$datos['id_institucion']);
            if ($ram->editarRam($conn)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Nota editadas con éxito.']);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Error al editar la Notas.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'errores' => $errores]);
        }
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se ha iniciado sesión.']);
}
