<?php
// model/Notificacion.php
require_once(__DIR__ . "/Conexion.php");
$conexion = Conexion::conectar();
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Insertar notificación
if (isset($_POST['agregar'])) {
    $destinatario = $_POST['destinatario'];
    $mensaje = $_POST['mensaje'];
    $conexion->query("INSERT INTO notificaciones (destinatario, mensaje) VALUES ('$destinatario', '$mensaje')");
    header("Location: NotificacionView.php");
    exit;
}

// Eliminar notificación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM notificaciones WHERE id = $id");
    header("Location: NotificacionView.php");
    exit;
}

// Obtener notificaciones
$notificaciones = $conexion->query("SELECT * FROM notificaciones ORDER BY fecha_envio DESC");
?>
