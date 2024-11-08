<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_materia'])) {
        $id_materia = $_POST['id_materia'];
        $alumnos = Alumno::obtenerAlumnosPorMateria($id_materia, $conn);

        if ($alumnos) {
            echo json_encode(['estado' => 'exito', 'alumnos' => $alumnos]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron alumnos.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Falta el parámetro id_materia.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
