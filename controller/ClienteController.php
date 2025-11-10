<?php
require_once("../model/Cliente.php");
require_once("../model/Usuario.php"); // <-- añadimos el modelo de usuario
$clienteModel = new Cliente();
$usuarioModel = new Usuario(); // <-- instancia del modelo de usuarios

// Guardar nuevo cliente
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];

    // Guardar cliente
    $clienteModel->agregar($nombre, $telefono, $correo, $direccion);

    // Crear usuario automáticamente
    $usuario = $correo; // Usamos el correo como nombre de usuario
    $claveTemporal = "1234"; // clave temporal visible
    $claveEncriptada = password_hash($claveTemporal, PASSWORD_DEFAULT);
    $rol = 'Visitante';
    $resultado = $usuarioModel->crearUsuario($usuario, $correo, $telefono, $claveHash, $rol);

if ($resultado === "existe") {
    // Simplemente mostrás un mensaje amigable
    echo "<script>alert('⚠️ El usuario ya existe en el sistema');</script>";
} elseif ($resultado === "creado") {
    echo "<script>alert('✅ Usuario creado correctamente');</script>";
} else {
    echo "<script>alert('❌ Error al crear el usuario');</script>";
}
    // Redirige pasando datos por GET
    header("Location: ../views/ClienteView.php?usuario=$usuario&clave=$claveTemporal");
    exit;
}
if (isset($_POST['crearUsuario'])){
      // Crear usuario automáticamente
    $usuario = $correo; // Usamos el correo como nombre de usuario
    $claveTemporal = "1234"; // clave temporal visible
    $claveEncriptada = password_hash($claveTemporal, PASSWORD_DEFAULT);
    $rol = 'Visitante';
    $resultado = $usuarioModel->crearUsuario($usuario, $correo, $telefono, $claveHash, $rol);
     // Simplemente mostrás un mensaje amigable
    echo "<script>alert('Usuario creado con exito');</script>";
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
