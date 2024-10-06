<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno = new Alumno('', '', '', '', '', ''); 
    $datos = $alumno->obtenerDatos(); // Asegúrate de que esto obtenga los datos correctamente

    $erroresValidar = $alumno->validarDatos($datos);
    $id_alumno = $_POST['id_alumno']; // Cambié esto para acceder correctamente a los datos

    if (empty($erroresValidar)) {
        $alumno->setNombre($datos['nombre']);
        $alumno->setApellido($datos['apellido']);
        $alumno->setDni($datos['dni']);
        $alumno->setEmail($datos['email']);
        $alumno->setFechaNacimiento($datos['fecha_nacimiento']);
        $alumno->setIdMateria($datos['id_materia']); 

        if ($alumno->editarAlumno($id_alumno, $conn)) {
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
