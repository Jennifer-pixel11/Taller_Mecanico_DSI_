<?php
require_once '../model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $cantidad = $_POST['cantidad'];

  $stmt = $conn->prepare("INSERT INTO inventario (nombre, cantidad) VALUES (?, ?)");
  $stmt->bind_param("si", $nombre, $cantidad);
  $stmt->execute();

  header("Location: ../Inventario.php");
  exit;
}
?>
