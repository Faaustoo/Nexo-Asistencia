<?php
session_start(); 
require_once 'autoLoader.php';

header('Content-Type: application/json');

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $data = Institucion::obtenerDatosInstitucion(); 
    $erroresValidar = Institucion::validarDatosInstitucion($data);

    if (empty($erroresValidar)) {
        $institucion = new Institucion($data['nombre_institucion'], $data['direccion_institucion'], $data['cue_institucion'], $data['id_profesor']);

        if ($institucion->crearInstitucion($conn)) {
            $idInstitucion = $conn->lastInsertId();
            
            $ram = new Ram(70, 60, 7, 6, $idInstitucion); 
            if ($ram->crearRam($conn)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Institución creada.', 'id_institucion' => $idInstitucion]);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Institución creada, pero error al crear RAM.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al crear la institución.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}
