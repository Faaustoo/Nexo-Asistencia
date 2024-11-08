<?php
session_start();
require_once 'autoLoader.php';

$database = new Database();
$conn = $database->connect();

if (isset($_SESSION['id_profesor'])) {
    $id_profesor = $_SESSION['id_profesor'];

    if (isset($id_profesor)) {
        $instituciones = Institucion::obtenerInstitucionesPorProfesor($conn, $id_profesor);
        echo json_encode(['estado' => 'exito', 'instituciones' => $instituciones]);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'ID del profesor no encontrado.']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se ha iniciado sesión.']);
}
?>
