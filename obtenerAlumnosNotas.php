<?php
session_start();
require_once 'autoLoader.php';

header('Content-Type: application/json');

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materia = $_POST['id_materia'];

    if ($id_materia) {
        $asistencias = Nota::obtenerEstadosAsistenciasPorAlumno($id_materia, $conn);
        
        if (!empty($asistencias)) {
            $id_institucion = $asistencias[0]['id_institucion'];
            
            $alumnos = Nota::obtenerDatosCompletosPorAlumno($id_materia, $conn);
            $ram = Nota::obtenerDatosRam($conn, $id_institucion);

        
            if ($alumnos && $ram) {
                echo json_encode(['estado' => 'exito','asistencias' => $asistencias,'notas' => $alumnos,'ram' => $ram]);
            } else {
                echo json_encode(['estado' => 'error','mensaje' => 'No se encontraron datos en una o más tablas: notas, asistencias o RAM.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron asistencias para la materia.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'El ID de materia es obligatorio.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>
