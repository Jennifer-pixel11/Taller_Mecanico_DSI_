<?php
require_once "../model/Conexion.php";
require_once "../model/Inventario.php";

// Conexión
$conexion = Conexion::conectar();
$inventario = new Inventario($conexion);

// Manejar POST: agregar o editar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion'],
        'cantidad' => $_POST['cantidad'],
        'precio' => $_POST['precio'],
        'id_proveedor' => $_POST['id_proveedor']
    ];

    // Manejo de imagen
    if (!empty($_FILES['imagen']['name'])) {
        $nombreArchivo = time() . "_" . $_FILES['imagen']['name'];
        $rutaDestino = "../public/uploads/" . $nombreArchivo;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        $data['imagen'] = "public/uploads/" . $nombreArchivo;
    }

    if (isset($_POST['agregar'])) {
        $inventario->agregar($data);
    } elseif (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $inventario->editar($id, $data);
    }

    header("Location: ../views/InventarioView.php");
    exit;
}

// Manejar GET: eliminar
if (isset($_GET['eliminar'])) {
    $inventario->eliminar($_GET['eliminar']);
    header("Location: ../views/InventarioView.php");
    exit;
}

// Datos para la vista
$productos = $inventario->listar();
$proveedores = $inventario->listarProveedores();
$editarProducto = isset($_GET['editar']) ? $inventario->obtener($_GET['editar']) : null;
?>


