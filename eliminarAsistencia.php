<?php 
session_start(); 
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect(); 

if (!$conn) {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Error de conexión a la base de datos.', 'errores' => []]);
    exit; // Detener la ejecución si no hay conexión
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear una instancia de la clase Asistencia
    $asistencia = new Asistencia('', '', '', '');

    $datos = $asistencia->obtenerFechaEliminar(); 
    $errores = $asistencia->validarFechaEliminar($datos); 

    if (empty($errores)) {
        $fecha = $datos['fecha'];
       
        // Verificar si existe la asistencia antes de eliminar
        if ($asistencia->existeAsistencia($conn, $fecha)) {
            if ($asistencia->eliminarAsistencia($conn, $fecha)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Asistencias eliminadas con éxito.', 'errores' => []]);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Error al eliminar las asistencias.', 'errores' => []]);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No hay asistencias registradas para la fecha indicada.', 'errores' => []]);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores de validación.', 'errores' => $errores]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
?>
