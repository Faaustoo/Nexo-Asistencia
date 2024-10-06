<?php
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect();
$erroresExiste = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno = new Alumno('', '', '', '', '', ''); // Crear instancia de Alumno
    $data = $alumno->obtenerDatos(); 
    $erroresValidar = $alumno->validarDatos($data); 

    if (empty($erroresValidar)) {
        $id_alumno = $data['id_alumno']; // Obtener el ID del alumno para editar
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $dni = $data['dni'];
        $email = $data['email'];
        $fecha_nacimiento = $data['fecha_nacimiento'];
        $id_materia = $data['id_materia'];

        $erroresExiste = $alumno->existe($data, $conn);

        if (empty($erroresExiste)) {

            $alumno->setNombre($nombre);
            $alumno->setApellido($apellido);
            $alumno->setDni($dni);
            $alumno->setEmail($email);
            $alumno->setFechaNacimiento($fecha_nacimiento);
            $alumno->setIdMateria($id_materia);

            if ($alumno->editarAlumno($id_alumno,$conn)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Alumno editado exitosamente.']);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Error al editar el Alumno.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'errores' => $erroresExiste]);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>
