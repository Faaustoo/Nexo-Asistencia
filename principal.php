<?php 
session_start();
require_once 'autoLoader.php'; 

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Iniciar sesion.']);
    exit;
}

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nombre = isset($_POST['nombre_institucion']) ? trim($_POST['nombre_institucion']) : '';
    $direccion = isset($_POST['direccion_institucion']) ? trim($_POST['direccion_institucion']) : '';

    // Validaciones simples
    if (empty($nombre) || empty($direccion)) {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Crear una nueva institución
    $institucion = new Institucion($nombre, $direccion);
    
    if ($institucion->create($conn)) {
        echo json_encode(['estado' => 'exito', 'mensaje' => 'Institución creada exitosamente.']);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Error al crear la institución.']);
    }

    $conn = null; // Cierra la conexión
    exit;
}
?>
