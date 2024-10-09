<?php
require_once 'autoLoader.php'; 

$database = new Database();
$conn = $database->connect();
$erroresExiste = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear instancia de Profesor
    $profesor = new Profesor('', '', '', '', '', ''); 
    $data = $profesor->obtenerDatos(); 

    // Validar datos
    $erroresValidar = $profesor->validarDatos($data); 

    if (empty($erroresValidar)) {
        $nombre = $data['nombre']; 
        $apellido = $data['apellido'];
        $dni = $data['dni'];
        $email = $data['email'];
        $contrasena = $data['contrasena'];
        $numero_legajo = $data['numero_legajo'];

        // Verificar si el registro ya existe
        $erroresExiste = $profesor->existe($data, $conn);

        if (empty($erroresExiste)) {
            // Establecer los datos en el objeto Profesor
            $profesor->setNombre($nombre);
            $profesor->setApellido($apellido);
            $profesor->setDni($dni);
            $profesor->setEmail($email);
            $profesor->setNumeroLegajo($numero_legajo);
            $profesor->setContrasena($contrasena);

            // Crear el registro en la base de datos
            if ($profesor->create($conn)) {
                echo json_encode(['estado' => 'exito', 'mensaje' => 'Creado exitosamente.']);
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Error al crear.']);
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
