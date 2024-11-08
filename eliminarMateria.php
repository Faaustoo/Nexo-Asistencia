<?php 
session_start(); 
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = Materia::obtenerDatosEliminar();
    $erroresValidar = Materia::validarDatosEliminar($datos);

    if (empty($erroresValidar)) {
        $nombre = $datos['nombre_materia'];
        $id_institucion = $datos['id_institucion'];
        
        if (Materia::eliminarMateria($conn, $nombre, $id_institucion)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Materia eliminada con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontró la materia en la institución especificada.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Errores en la validación.', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se envió por POST.']);
}

