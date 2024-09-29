<?php
require_once 'Alumno.php';
require_once 'conexion.php'; // Incluye tu archivo de conexión
session_start(); // Asegúrate de que la sesión esté iniciada para acceder a las variables de sesión

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno = new Alumno('', '', '', '', '', ''); // Inicializa el objeto Alumno
    $data = $alumno->obtenerDatos();
    $erroresValidar = $alumno->validarDatos($data);
   
    // Verifica si hay errores de validación
    if (empty($erroresValidar)) {
        // Establece los datos del alumno
        $alumno->setNombre($data['nombre']);
        $alumno->setApellido($data['apellido']);
        $alumno->setDni($data['dni']);
        $alumno->setEmail($data['email']);
        $alumno->setFechaNacimiento($data['fecha_nacimiento']);
        $alumno->setIdMateria($_SESSION['id_materia']); 

        // Crear el alumno en la base de datos
        if ($alumno->crearAlumno($conn)) { 
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Alumno registrado con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al registrar el alumno.']);
        }
       
    } else {
        // Si hay errores de validación, los devuelve
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}
?>
