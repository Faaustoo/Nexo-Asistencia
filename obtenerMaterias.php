<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_institucion = $_POST['id_institucion'];
    $materias = Materia::obtenerMateriasPorInstitucion($conn, $id_institucion);
    
    if (!empty($materias)) {
        echo json_encode(['estado' => 'exito', 'materias' => $materias]);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron materias.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>
