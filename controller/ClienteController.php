<?php
require_once("../model/Cliente.php");
$clienteModel = new Cliente();

// Guardar nuevo cliente
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];

    $clienteModel->agregar($nombre, $telefono, $correo, $direccion);
    header("Location: ../views/ClienteView.php?msg=Cliente agregado");
    exit;
}

// Editar cliente
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];

    $clienteModel->editar($id, $nombre, $telefono, $correo, $direccion);
    header("Location: ../views/ClienteView.php?msg=Cliente actualizado");
    exit;
}

// Eliminar cliente
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $clienteModel->eliminar($id);
    header("Location: ../views/ClienteView.php?msg=Cliente eliminado");
    exit;
}
