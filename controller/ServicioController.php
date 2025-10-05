<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once("../model/Servicio.php");
require_once '../model/Conexion.php';

$servicioModel = new Servicio();
$servicios = $servicioModel->obtenerServicios();

$servicioEditar = null;
if (isset($_GET['editar'])) {
    $servicioEditar = $servicioModel->obtenerPorId($_GET['editar']);
}

// Guardar servicio nuevo (manual)
if (isset($_POST['guardar'])) {
    $vehiculo_id = $_POST['vehiculo_id'];
    $descripcion = $_POST['descripcion'];
    $fecha       = $_POST['fecha'];
    $costo       = $_POST['costo'];

    $servicioModel->agregar($vehiculo_id, $descripcion, $fecha, $costo);

    header("Location: ../views/ServicioView.php?msg=Servicio registrado");
    exit;
}

// Editar servicio
if (isset($_POST['editar'])) {
    $id          = $_POST['id'];
    $vehiculo_id = $_POST['vehiculo_id'];
    $descripcion = $_POST['descripcion'];
    $fecha       = $_POST['fecha'];
    $costo       = $_POST['costo'];

    $servicioModel->editar($id, $vehiculo_id, $descripcion, $fecha, $costo);

    header("Location: ../views/ServicioView.php?msg=Servicio actualizado");
    exit;
}

// Eliminar servicio
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $servicioModel->eliminar($id);

    header("Location: ../views/ServicioView.php?msg=Servicio eliminado");
    exit;
}

?>
