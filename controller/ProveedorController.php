<?php
// controller/ProveedorController.php
// Conexión
include '../controller/conexion.php';

$conexion = new mysqli("localhost", "root", "root", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Agregar proveedor
if (isset($_POST['agregarProveedor'])) {
    $nombre = $_POST['nombre'];
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $direccion = $_POST['direccion'];
    $rubro = $_POST['rubro'];

    $conexion->query("INSERT INTO proveedor_insumos (nombre, nombre_contacto, telefono, correo_electronico, direccion, rubro) 
                      VALUES ('$nombre', '$nombre_contacto', '$telefono', '$correo_electronico', '$direccion', '$rubro')");
    header("Location: ProveedorView.php");
    exit;
}
// Editar proveedor
if (isset($_POST['editarProveedor'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $direccion = $_POST['direccion'];
    $rubro = $_POST['rubro'];

    $conexion->query("UPDATE proveedor_insumos 
                      SET nombre = '$nombre', nombre_contacto = '$nombre_contacto', telefono = '$telefono', 
                          correo_electronico = '$correo_electronico', direccion = '$direccion', rubro = '$rubro' 
                      WHERE id_proveedor = $id");
    header("Location: ProveedorView.php");
    exit;
}
// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM proveedor_insumos WHERE id_proveedor = $id");
    header("Location: ProveedorView.php");
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
