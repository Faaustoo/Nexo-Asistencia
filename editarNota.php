<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $datos = Nota::obtenerDatosNotas();
    $erroresValidar = Nota::validarDatosNotas($datos);

    if (empty($erroresValidar)) {
        $nota = new Nota($datos['parcial_uno'], $datos['parcial_dos'], $datos['trabajo_final'], $datos['id_alumno'], $datos['id_materia']);
        
        if ($nota->editarNota($conn, $datos['id_alumno'], $datos['id_materia'])) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Nota editada con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al editar la nota.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en la validación.', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
?>
