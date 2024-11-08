<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //json_decode función que toma un string en formato JSON y lo convierte en un tipo de dato de PHP.
    // segundo parámetro de json_decode, el resultado puede ser un objeto o un array. en este caso un array 
    $data = json_decode($_POST['asistencias'], true);
    $errores = []; 

    $fecha = $_POST['fecha'];
    $id_materia = $_POST['id_materia'];

    if (Asistencia::existeAsistenciaProfesor($conn, $fecha, $id_materia)) {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Ya se ha tomado asistencia la fecha seleccionada.']);
        exit; 
    }
    foreach ($data as $datos) { 
        $asistencia = new Asistencia($fecha, $datos['estado'], $datos['id_alumno'], $id_materia);
        if (!$asistencia->crearAsistencia($conn)) {
            $errores[] = "Error al registrar asistencia.";
        }
    }
    
    if (empty($errores)) {
        echo json_encode(['estado' => 'exito', 'mensaje' => 'Asistencias registradas con éxito.']);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores al registrar asistencias.', 'errores' => $errores]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}

