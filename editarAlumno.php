<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alumno = $_POST['id_alumno'];
    $datos = Alumno::obtenerDatos(); 
    $erroresValidar = Alumno::validarDatos($datos);

    if (empty($erroresValidar)) {
        $alumno = new Alumno($datos['nombre'], $datos['apellido'], $datos['dni'], $datos['email'], $datos['fecha_nacimiento'], $datos['id_materia']);
        
        if ($alumno->editarAlumno($conn,$id_alumno)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Alumno editado con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al editar el alumno.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en la validación.', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.', 'errores' => []]);
}
