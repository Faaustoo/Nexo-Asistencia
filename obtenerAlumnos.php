<?php
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID de materia del POST
    $id_materia = $_POST['id_materia'] ?? null;

    // Verificar si se proporcionó un ID de materia
    if ($id_materia) {
        $alumno = new Alumno('', '', '', '', '', ''); 
        $alumnos = $alumno->obtenerAlumnosPorMateria($id_materia, $conn);
        
        // Comprobar si se encontraron alumnos
        if ($alumnos) {
            echo json_encode(['estado' => 'exito', 'alumnos' => $alumnos]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron alumnos.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'El ID de materia es obligatorio.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>

