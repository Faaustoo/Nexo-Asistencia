<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $datos = Alumno::obtenerDatosEliminar();
    

    if (!empty($datos['id_alumno'])) {
        $id_alumno = $datos['id_alumno']; 

        if (Alumno::eliminarAlumno($id_alumno, $conn)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Alumno eliminado con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al eliminar el alumno.', 'errores' => []]);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'ID de alumno no proporcionado.', 'errores' => []]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
?>
