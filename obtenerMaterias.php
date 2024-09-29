<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['id_institucion']) && !empty($_POST['id_institucion'])) {
        $id_institucion = $_POST['id_institucion'];

        $materia = new Materia('', '');
        $materia->setIdInstitucion($id_institucion);
        $materias = $materia->obtenerMateriasPorInstitucion($conn);

        if (!empty($materias)) {
            echo json_encode(['estado' => 'exito', 'materias' => $materias]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se encontraron materias.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'El id de institución es obligatorio.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>
