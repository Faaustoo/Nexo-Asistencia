<?php
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno = new Alumno('', '', '', '', '', ''); 
    $data = $alumno->obtenerDatos();
    $erroresValidar = $alumno->validarDatos($data);

    if (empty($erroresValidar)) {
        $alumno->setNombre($data['nombre']);
        $alumno->setApellido($data['apellido']);
        $alumno->setDni($data['dni']);
        $alumno->setEmail($data['email']);
        $alumno->setFechaNacimiento($data['fecha_nacimiento']);
        $alumno->setIdMateria($data['id_materia']); 

        $erroresExistencia = $alumno->existe(['dni' => $data['dni'],'email' => $data['email']], $conn);

        if (!empty($erroresExistencia)) {
            echo json_encode(['estado' => 'error', 'errores' => $erroresExistencia]);
            exit;
        }

        if ($alumno->crearAlumno($conn)) { 
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Alumno registrado con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al registrar el alumno.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}
