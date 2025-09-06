<?php
// model/Cita.php
session_start();
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Desconocido';

// Conexión
$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Agendar nueva cita
if (isset($_POST['agendar'])) {
    //$cliente = $_POST['cliente'];
    $cliente = $usuario;
    $vehiculo = $_POST['vehiculo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];
    $servicio = $_POST['servicio'];
    $conexion->query("INSERT INTO citas (cliente, vehiculo, fecha, hora, descripcion, servicio, usuario) 
                      VALUES ('$cliente', '$vehiculo', '$fecha', '$hora', '$descripcion', '$servicio', '$usuario')");
    header("Location: Cita.php");
    exit;
}

// Eliminar cita
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM citas WHERE id = $id");
    header("Location: Cita.php");
    exit;
}

// Obtener citas
$citas = $conexion->query("SELECT * FROM citas");
?>
