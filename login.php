<?php 
session_start(); 
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = Profesor::obtenerDatosLogin(); 
    $erroresValidar = Profesor::validarDatosLogin($data); 

    if (empty($erroresValidar)) {
        $profesores = Profesor::obtenerProfesores($conn);
        $usuarioValido = Profesor::validarLogin($data['email'], $data['contrasena'], $profesores);
        
        if ($usuarioValido) {
            $_SESSION['id_profesor'] = $usuarioValido['id_profesor'];
            echo json_encode([
                'estado' => 'exito',
                'mensaje' => 'Login exitoso.',
                'id_profesor' => $usuarioValido['id_profesor']
            ]);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Email o contraseña incorrecto.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
}
