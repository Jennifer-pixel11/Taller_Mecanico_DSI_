<?php
// controller/ProveedorController.php
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Incluimos los archivos necesarios
require_once '../model/Conexion.php';
require_once '../model/Proveedor.php';

// 2. Creamos una instancia del Modelo. Él es el único que hablará con la BD.
$proveedorModel = new Proveedor();

// --- ACCIONES ---

// Si la solicitud es para AGREGAR
if (isset($_POST['agregarProveedor'])) {
    // Recolectamos los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $nombre_contacto = trim($_POST['nombre_contacto'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo_electronico = trim($_POST['correo_electronico'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $rubro = trim($_POST['rubro'] ?? '');

    // Llamamos al método del MODELO para que guarde los datos
    $proveedorModel->agregarProveedor($nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro);
    
    // Redirigimos a la vista con un mensaje de éxito
    header("Location: ../views/ProveedorView.php?msg=Proveedor+agregado");
    exit;
}

// Si la solicitud es para EDITAR
if (isset($_POST['editarProveedor'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $nombre_contacto = trim($_POST['nombre_contacto'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo_electronico = trim($_POST['correo_electronico'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $rubro = trim($_POST['rubro'] ?? '');
    
    // Llamamos al método del MODELO para que actualice los datos
    $proveedorModel->actualizarProveedor($id, $nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro);

    // Redirigimos
    header("Location: ../views/ProveedorView.php?msg=Proveedor+actualizado");
    exit;
}

// Si la solicitud es para ELIMINAR (Esta es la sección que te daba el error en la línea 65)
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    
    // NO hacemos la consulta aquí.
    // LLAMAMOS al método del modelo para que él haga el trabajo.
    $proveedorModel->eliminarProveedor($id);
    
    // Redirigimos
    header("Location: ../views/ProveedorView.php?msg=Proveedor+eliminado");
    exit;
}

// Si se llega al controlador sin ninguna acción, simplemente redirigimos a la vista principal.
header("Location: ../views/ProveedorView.php");
exit;
