<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $institucion = new Institucion('', '', '', ''); 
    $datos = $institucion->obtenerDatosEliminar();
    $erroresValidar = $institucion->validarDatosEliminar($datos);

    if (empty($erroresValidar)) {
        $nombreInstitucion = $datos['nombre_institucion'];

        if ($institucion->eliminarInstitucion($conn, $nombreInstitucion)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Institución eliminada con éxito.', 'errores' => []]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al eliminar la institución.', 'errores' => []]);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en la validación.', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
?>
