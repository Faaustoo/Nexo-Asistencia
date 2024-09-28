<?php 
session_start(); 
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profesor = new Profesor('', '', '', '', '', '');
    $data = $profesor->obtenerDatosLogin(); 
    $erroresValidar = $profesor->validarDatosLogin($data); 

    if (empty($erroresValidar)) {
        $profesores = $profesor->obtenerProfesores($conn);
        $usuarioValido = $profesor->validarLogin($data['email'], $data['contrasena'], $profesores);
        
        if ($usuarioValido) {

            $_SESSION['id_profesor'] = $usuarioValido['id_profesor']; 
            echo json_encode(['estado' => 'exito', 'mensaje' => 'Login exitoso.']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Email o contraseña incorrecto.']);
        }
    } else {
        echo json_encode(['estado' => 'error', 'errores' => $erroresValidar]);
    }
}
?>