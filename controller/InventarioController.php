<?php
// Conexión
include '../controller/conexion.php';

// Agregar producto
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $id_proveedor = $_POST['id_proveedor'];
    $imagen = $_FILES['imagen']['name'];
    $ruta_temp = $_FILES['imagen']['tmp_name'];
    $ruta_final = 'uploads/' . $imagen;
    move_uploaded_file($ruta_temp, $ruta_final);
    $conexion->query("INSERT INTO inventario (nombre, descripcion, cantidad, precio, imagen, id_proveedor) VALUES ('$nombre', '$descripcion', '$cantidad', '$precio', '$ruta_final', '$id_proveedor')");
    header("Location: Inventario.php");
    exit;
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM inventario WHERE id = $id");
    header("Location: Inventario.php");
    exit;
}

// Editar producto
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $id_proveedor = $_POST['id_proveedor'];

    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $ruta_temp = $_FILES['imagen']['tmp_name'];
        $ruta_final = 'uploads/' . $imagen;
        move_uploaded_file($ruta_temp, $ruta_final);
        $conexion->query("UPDATE inventario SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad', precio='$precio', id_proveedor='$id_proveedor', imagen='$ruta_final' WHERE id=$id");
    } else {
        $conexion->query("UPDATE inventario SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad', precio='$precio', id_proveedor='$id_proveedor' WHERE id=$id");
    }
    header("Location: Inventario.php");
    exit;
}

// Obtener producto para editar
$editarProducto = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM inventario WHERE id = $id");
    $editarProducto = $resultado->fetch_assoc();
}

// Obtener lista de productos
$productos = $conexion->query("SELECT inventario.*, proveedor_insumos.nombre AS proveedor_nombre FROM inventario LEFT JOIN proveedor_insumos ON inventario.id_proveedor = proveedor_insumos.id_proveedor");

// Obtener lista de proveedores
$proveedores = $conexion->query("SELECT id_proveedor, nombre FROM proveedor_insumos");
