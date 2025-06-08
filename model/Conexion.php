<?php
$host = "127.0.0.1:3307";
$user = "root";
$password = "";
$db = "taller";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}
?>
