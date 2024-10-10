<?php
session_start(); 
require_once 'autoLoader.php';

header('Content-Type: application/json'); // Asegúrate de establecer el encabezado

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materia = $_POST['id_materia'];

    if ($id_materia) {
        $nota = new Nota('', '', '', '', ''); 
        $notas = $nota->obtenerDatosAlumnos($id_materia, $conn);
        $asistencias = $nota->obtenerEstadosAsistenciasPorAlumno($id_materia, $conn);
        
        if ($notas) {
            echo json_encode(['estado' => 'exito', 'notas' => $notas, 'asistencias' => $asistencias]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron notas o asistencias.']);
        }
    } else {
        echo json_encode([
            'estado' => 'error', 'mensaje' => 'El ID de materia es obligatorio.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
