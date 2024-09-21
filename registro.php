<?php
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect();
$erroresExiste = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profesor = new Profesor('', '', '', '', '', '');
    $data = $profesor->obtenerDatos(); 
    $erroresValidar = $profesor->validarDatos($data); 

    
    if (empty($erroresValidar)) {
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $dni = $data['dni'];
        $email = $data['email'];
        $numero_legajo = $data['numero_legajo'];
        $contrasena = $data['contrasena'];

        $profesor = new Profesor($nombre, $apellido, $dni, $email, $contrasena, $numero_legajo);
        $erroresExiste = $profesor->existe($data, $conn);

            if (empty($erroresExiste)) {
                if ($profesor->create($conn)) {
                    echo json_encode(['estado' => 'exito', 'mensaje' => 'Profesor registrado exitosamente.']);
                } else {
                    echo json_encode(['estado' => 'error', 'mensaje' => 'Error al registrar el profesor.']);
                }
            } else {
                echo json_encode(['estado' => 'error', 'errores' => $erroresExiste]);
            }
        } else {
            echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>