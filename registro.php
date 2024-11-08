<?php
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect();
$erroresExiste = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = profesor::obtenerDatos();
    $erroresValidar = profesor::validarDatos($data);
    $erroresExiste = profesor::existe($data, $conn); 

    if (empty($erroresValidar) && empty($erroresExiste)) {
        $profesor = new profesor($data['nombre'], $data['apellido'], $data['dni'], $data['email'], $data['contrasena'], $data['numero_legajo']);
            if ($profesor->create($conn)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Creado exitosamente.']);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Error al crear.']);
            }
    } else {
        // array_merge combina uno o mas arrays en un solo array 
        echo json_encode(['estado' => 'error', 'errores' => array_merge($erroresValidar, $erroresExiste)]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>
