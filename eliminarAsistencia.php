<?php 
session_start(); 
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos
    $datos = Asistencia::obtenerEliminar(); 
    $errores = Asistencia::validarEliminar($datos); 

    if (empty($errores)) {
        $fecha = $datos['fecha'];
        $id_alumno = $datos['id'];

        if (Asistencia::existeAsistencia($conn, $fecha, $id_alumno)) {
            if (Asistencia::actualizarAsistencia($conn, $fecha, $id_alumno)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'La asistencia ha sido cambiada de Presente a Ausente con éxito.']);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Error al actualizar el estado de la asistencia.', 'errores' => []]);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No hay asistencias registradas para la fecha y Alumno seleccionado.', 'errores' => []]);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => $errores]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
?>
