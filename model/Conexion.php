<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "taller";

$conn = new mysqli($host, $user, $password, $db);

// Habilita errores si la conexión falla
if ($conn->connect_error) {
  die("<script>alert('Error de conexión a la base de datos: " . $conn->connect_error . "');window.location.href='../index.html';</script>");
}
?>
