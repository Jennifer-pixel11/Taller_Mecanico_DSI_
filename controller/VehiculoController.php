<?php
require_once("../model/Vehiculo.php");
$vehiculoModel = new Vehiculo();

// Guardar nuevo
if (isset($_POST['agregar'])) {
    $placa   = $_POST['placa'];
    $cliente = $_POST['cliente'];
    $marca   = $_POST['marca'];
    $modelo  = $_POST['modelo'];

    $vehiculoModel->agregar($placa, $cliente, $marca, $modelo);
    header("Location: ../views/VehiculoView.php?msg=Vehículo agregado");
    exit;
}

// Editar
if (isset($_POST['editar'])) {
    $id      = $_POST['id'];
    $placa   = $_POST['placa'];
    $cliente = $_POST['cliente'];
    $marca   = $_POST['marca'];
    $modelo  = $_POST['modelo'];

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
