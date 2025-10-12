<?php
// controller/ProveedorController.php
// Conexión
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Proveedor.php';
require_once '../model/Conexion.php';

$proveedorModel = new Proveedor();
$proveedores = $proveedorModel->obtenerProveedores();

$proveedorEditar = null;
if (isset($_GET['editar'])) {
    $proveedorEditar = $proveedorModel->obtenerPorId($_GET['editar']);
}


// Agregar proveedor
if (isset($_POST['agregarProveedor'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $nombre_contacto = trim($_POST['nombre_contacto'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo_electronico = trim($_POST['correo_electronico'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $rubro = trim($_POST['rubro'] ?? '');

    // Server-side validation
    if (empty($nombre) || empty($nombre_contacto) || empty($telefono) || empty($correo_electronico) || empty($direccion) || empty($rubro)) {
        header("Location: ProveedorView.php?error=Por+favor+complete+todos+los+campos+obligatorios");
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO proveedor_insumos (nombre, nombre_contacto, telefono, correo_electronico, direccion, rubro) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro);
    $stmt->execute();
    header("Location: ProveedorView.php?msg=Proveedor+agregado");
    exit;
}
// Editar proveedor
if (isset($_POST['editarProveedor'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $nombre_contacto = trim($_POST['nombre_contacto'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo_electronico = trim($_POST['correo_electronico'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $rubro = trim($_POST['rubro'] ?? '');

    // Server-side validation
    if (empty($id) || empty($nombre) || empty($nombre_contacto) || empty($telefono) || empty($correo_electronico) || empty($direccion) || empty($rubro)) {
        header("Location: ProveedorView.php?error=Por+favor+complete+todos+los+campos+obligatorios");
        exit;
    }

    $stmt = $conexion->prepare("UPDATE proveedor_insumos SET nombre=?, nombre_contacto=?, telefono=?, correo_electronico=?, direccion=?, rubro=? WHERE id_proveedor=?");
    $stmt->bind_param("ssssssi", $nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro, $id);
    $stmt->execute();
    header("Location: ProveedorView.php?msg=Proveedor+actualizado");
    exit;
}
// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $stmt = $conexion->prepare("DELETE FROM proveedor_insumos WHERE id_proveedor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ProveedorView.php?msg=Proveedor+eliminado");
    exit;
}
// Obtener proveedor para editar
$editarProveedor = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM proveedor_insumos WHERE id_proveedor = $id");
    $editarProveedor = $resultado->fetch_assoc();
}
// Obtener proveedores
$resultado = $conexion->query("SELECT * FROM proveedor_insumos");
