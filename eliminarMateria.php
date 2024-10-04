<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materia = new Materia('', '', '', ''); 
    $datos = $materia->obtenerDatosEliminar();
    $erroresValidar = $materia->validarDatosEliminar($datos);

    if (empty($erroresValidar)) {
        $nombreMateria = $datos['nombre_materia'];

        if ($materia->eliminarMateria($conn, $nombreMateria)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Materia eliminada con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontro materia.'] );
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en la validación.', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}
?>
