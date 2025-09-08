<?php
// model/Servicio.php
 include("../controller/ServicioController.php"); 

session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] !== 'Gerente' && $_SESSION['rol'] !== 'Mecánico')) {
  header("Location: ../index.html");
  exit;
}

$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Insertar nuevo servicio
if (isset($_POST['agregar'])) {
    $vehiculo = $_POST['vehiculo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $costo = $_POST['costo'];
    $conexion->query("INSERT INTO servicios (vehiculo, descripcion, fecha, costo) VALUES ('$vehiculo', '$descripcion', '$fecha', '$costo')");
    header("Location: ServicioView.php");
    exit;
}

// Eliminar servicio
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM servicios WHERE id = $id");
    header("Location: ServicioView.php");
    exit;
}

// Editar servicio
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $vehiculo = $_POST['vehiculo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $costo = $_POST['costo'];
    $conexion->query("UPDATE servicios SET vehiculo='$vehiculo', descripcion='$descripcion', fecha='$fecha', costo='$costo' WHERE id=$id");
    header("Location: ServicioView.php");
    exit;
}

// Obtener para editar
$editar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM servicios WHERE id = $id");
    $editar = $resultado->fetch_assoc();
}

// Obtener lista
$servicios = $conexion->query("SELECT * FROM servicios");
?>
