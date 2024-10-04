<?php
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno = new Alumno('', '', '', '', '', ''); 
    $data = $alumno->obtenerDatos();
    $erroresValidar = $alumno->validarDatos($data);

    // Captura el id_materia desde los datos recibidos
    $id_materia = $_POST['id_materia'] ?? null; // Usamos el operador null coalescing

    if (empty($erroresValidar)) {
        // Asignar los valores a la instancia del alumno
        $alumno->setNombre($data['nombre']);
        $alumno->setApellido($data['apellido']);
        $alumno->setDni($data['dni']);
        $alumno->setEmail($data['email']);
        $alumno->setFechaNacimiento($data['fecha_nacimiento']);
        $alumno->setIdMateria($id_materia); // Ahora usamos el id_materia obtenido

        // Verificar si el alumno ya existe
        $erroresExistencia = $alumno->existe(['dni' => $data['dni'],'email' => $data['email']], $conn);

        if (!empty($erroresExistencia)) {
            echo json_encode(['estado' => 'error', 'errores' => $erroresExistencia]);
            exit;
        }

        // Crear el alumno
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
