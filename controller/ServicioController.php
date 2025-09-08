<?php
// controller/ProveedorController.php

$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Agregar 
if (isset($_POST['agregarServicio'])) {
    $vehiculo = $_POST['vehiculo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $costo = $_POST['costo'];

    $conexion->query("INSERT INTO servicios (vehiculo, descripcion, fecha, costo) 
                      VALUES ('$vehiculo', '$descripcion', '$fecha', '$costo')");
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

// Obtener proveedores
$resultado = $conexion->query("SELECT * FROM proveedor_insumos");
