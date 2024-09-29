<?php 
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materia = new Materia('', ''); 
    $data = $materia->obtenerDatos(); 
    $erroresValidar = $materia->validarDatos($data);

    if (empty($erroresValidar)) {
        $materia->setNombre($data['nombre_materia']);
        $materia->setIdInstitucion($data['id_institucion']);

        if ($materia->crearMateria($conn)) {
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Materia creada con éxito.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al crear la materia.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
