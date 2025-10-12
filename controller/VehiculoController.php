<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once("../model/Vehiculo.php");
require_once '../model/Conexion.php';
$vehiculoModel = new Vehiculo();
$vehiculos = $vehiculoModel->obtenerVehiculos();

$vehiculoEditar = null;
if (isset($_GET['editar'])) {
    $vehiculoEditar = $vehiculoModel->obtenerPorId($_GET['editar']);
}


// Guardar nuevo
if (isset($_POST['agregar'])) {
    $placa   = $_POST['placa'] ?? '';
    $cliente = $_POST['cliente'] ?? '';
    $marca   = $_POST['marca'] ?? '';
    $modelo  = $_POST['modelo'] ?? '';

    // Server-side validation
    if (empty($placa) || empty($cliente) || empty($marca) || empty($modelo)) {
        header("Location: ../views/VehiculoView.php?error=Por+favor+complete+todos+los+campos+obligatorios");
        exit;
    }

    $vehiculoModel->agregar($placa, $cliente, $marca, $modelo);
    header("Location: ../views/VehiculoView.php?msg=Vehículo agregado");
    exit;
}

// Editar
if (isset($_POST['editar'])) {
    $id      = $_POST['id'] ?? '';
    $placa   = $_POST['placa'] ?? '';
    $cliente = $_POST['cliente'] ?? '';
    $marca   = $_POST['marca'] ?? '';
    $modelo  = $_POST['modelo'] ?? '';

    // Server-side validation
    if (empty($id) || empty($placa) || empty($cliente) || empty($marca) || empty($modelo)) {
        header("Location: ../views/VehiculoView.php?error=Por+favor+complete+todos+los+campos+obligatorios");
        exit;
    }

    $vehiculoModel->editar($id, $placa, $cliente, $marca, $modelo);
    header("Location: ../views/VehiculoView.php?msg=Vehículo actualizado");
    exit;
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $vehiculoModel->eliminar($id);
    header("Location: ../views/VehiculoView.php?msg=Vehículo eliminado");
    exit;
}
?>