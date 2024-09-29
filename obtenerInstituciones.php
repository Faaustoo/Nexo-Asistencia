<?php
session_start();
require_once 'autoLoader.php';

if (isset($_SESSION['id_profesor'])) {
    $database = new Database();
    $conn = $database->connect();

    $institucion = new Institucion('', '', '', $_SESSION['id_profesor']);
    $instituciones = $institucion->obtenerInstitucionesProfesor($conn);

    echo json_encode(['estado' => 'exito', 'instituciones' => $instituciones]);
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se ha iniciado sesión.']);
}
?>