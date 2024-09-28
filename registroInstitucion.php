<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener el ID del profesor de la sesión
    $id_profesor = $_SESSION['id_profesor'];
    
    // Crear una nueva instancia de Institucion, pasando el id_profesor
    $institucion = new Institucion('', '', '', $id_profesor); // Agregar el id_profesor
    $data = $institucion->obtenerDatos(); 
    $erroresValidar = $institucion->validarDatos($data);

    $institucion->setCue($data['cue_institucion']); 
    if ($institucion->existeCue($conn)) {
        $erroresValidar[] = 'El CUE ya existe en la base de datos.'; 
    }

    if (empty($erroresValidar)) {
        $institucion->setNombre($data['nombre_institucion']);
        $institucion->setDireccion($data['direccion_institucion']);
        
        if ($institucion->crearInstitucion($conn)) { 
            $id_institucion = $conn->lastInsertId();
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Institución creada con éxito.', 'id_institucion' => $id_institucion]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al crear la institución.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}
?>