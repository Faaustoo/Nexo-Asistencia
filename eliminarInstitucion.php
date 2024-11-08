<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $datos = Institucion::obtenerDatosEliminarInstitucion();
    $erroresValidar = Institucion::validarDatosEliminarInstitucion($datos);

    if (empty($erroresValidar)) {
        $nombreInstitucion = $datos['nombre_institucion'];
        $id_profesor = $datos['id_profesor'];

        if (Institucion::eliminarInstitucion($conn, $nombreInstitucion, $id_profesor)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Institución eliminada con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al eliminar la institución.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en la validación.', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}
