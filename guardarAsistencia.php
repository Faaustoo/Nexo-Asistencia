<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

// Verifica si el método de solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inicializa la clase Asistencia
    $asistencia = new Asistencia('', '', '', ''); 

    // Obtiene los datos de asistencia directamente desde la solicitud POST
    $datos = json_decode($_POST['asistencias'], true); // Convertir JSON a array

    $errores = []; // Inicializa el array de errores
    foreach ($datos as $entrada) {
        // Establece los valores directamente desde el array
        $asistencia->setFecha($_POST['fecha']);
        $asistencia->setEstado($entrada['estado']); 
        $asistencia->setIdAlumno($entrada['id_alumno']);
        $asistencia->setIdMateria($_POST['id_materia']);

        // Intenta guardar la asistencia
        if (!$asistencia->crearAsistencia($conn)) {
            $errores[] = "Error al registrar asistencia para el alumno ID " . $entrada['id_alumno'] . ".";
        }
    }

    // Si no hay errores, se devuelve un mensaje de éxito
    if (empty($errores)) {
        echo json_encode(['estado' => 'exito', 'mensaje' => 'Asistencias registradas con éxito.']);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores al registrar asistencias.', 'errores' => $errores]);
    }

} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
