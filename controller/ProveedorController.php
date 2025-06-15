<?php
// controller/ProveedorController.php

$conexion = new mysqli("localhost", "root", "", "taller");
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
    header("Location: Proveedor.php");
    exit;
}

// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM proveedor_insumos WHERE id_proveedor = $id");
    header("Location: Proveedor.php");
    exit;
}

// Obtener proveedores
$resultado = $conexion->query("SELECT * FROM proveedor_insumos");
