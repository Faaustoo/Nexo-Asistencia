<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = Alumno::obtenerDatos(); 
    $erroresValidar = Alumno::validarDatos($data);

    if (empty($erroresValidar)) {
        // Verificar si el DNI ya está registrado para la materia
        if (Alumno::dniExisteParaMateria($data['dni'], $data['id_materia'], $conn)) {
            echo json_encode(['estado' => 'error', 'mensaje' => 'El DNI ya está registrado para esta materia.']);
            exit;
        }

        $alumno = new Alumno($data['nombre'], $data['apellido'], $data['dni'], $data['email'], $data['fecha_nacimiento'], $data['id_materia']);
        if ($alumno->crearAlumno($conn)) {
            $id_alumno = $conn->lastInsertId();
            $nota = new Nota(0, 0, 0, $id_alumno, $data['id_materia']);
            if ($nota->insertarNota($conn)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Alumno registrado con éxito.']);
                exit; 
            }
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en los datos del formulario.', 'errores' => $erroresValidar]);
    }

} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}

