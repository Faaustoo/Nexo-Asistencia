<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if (isset($_SESSION['id_profesor'])) {
    $idInstitucion = $_POST['id_institucion'];
    
    $datos = Ram::obtenerDatosRam($conn, $idInstitucion);
    if ($datos) {
        echo json_encode(['estado' => 'exito', 'datos' => $datos]);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron datos.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se ha iniciado sesión.']);
}
