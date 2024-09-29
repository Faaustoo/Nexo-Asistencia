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

        $erroresExiste = $profesor->existe($data, $conn);

        if (empty($erroresExiste)) {
            
            $profesor->setNombre($nombre);
            $profesor->setApellido($apellido);
            $profesor->setDni($dni);
            $profesor->setEmail($email);
            $profesor->setNumeroLegajo($numero_legajo);
            $profesor->setContrasena($contrasena); 

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