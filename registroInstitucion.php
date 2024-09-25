<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $institucion = new Institucion('', '', '');
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
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Institución creada con éxito.']);
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
