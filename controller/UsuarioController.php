<?php
require_once '../model/Conexion.php';
session_start();

if (isset($_POST['accion'])) {
  $accion = $_POST['accion'];
  $usuario = trim($_POST['usuario']);
  $clave = trim($_POST['clave']);

  if ($accion === 'login') {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      if (password_verify($clave, $user['clave'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../main.html");
        exit;
      }
    }
    echo "<script>alert('Credenciales incorrectas');window.location.href='../index.html';</script>";
    exit;
  }

  if ($accion === 'register') {
    // Verificar si ya existe el usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "<script>alert('El usuario ya existe');window.location.href='../index.html';</script>";
      exit;
    }

    // Insertar nuevo usuario
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $claveHash);

    if ($stmt->execute()) {
      echo "<script>alert('Usuario registrado correctamente');window.location.href='../index.html';</script>";
    } else {
     
    }
    exit;
  }
}
?>
