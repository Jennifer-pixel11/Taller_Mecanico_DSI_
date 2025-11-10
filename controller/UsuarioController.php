<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../model/Conexion.php';
session_start();

// Conexión
$conn = Conexion::conectar();

// Cierre de sesión
if (isset($_GET['accion']) && $_GET['accion'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ../index.html");
    exit;
}

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);

    if ($accion === 'login') {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($clave, $user['clave'])) {
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['rol'] = $user['rol'];
                 // ✅ Redirección según el rol
                if ($user['rol'] === 'Visitante') {
                    header("Location: ../views/ClientePerfilView.php");
                } else {
                    header("Location: ../main.php");
                }
                exit;
            } else {
                echo "<script>alert('Contraseña incorrecta');window.location.href='../index.html';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Usuario no encontrado');window.location.href='../index.html';</script>";
            exit;
        }
    }

    if ($accion === 'register') {
        $rol = 'Visitante'; // por defecto
        $correo = isset($_POST['correo']) ? trim($_POST['correo']) : 'sin_correo@example.com';
        $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;

        // Solo el gerente puede elegir el rol
        if (isset($_POST['rol']) && isset($_SESSION['rol']) && $_SESSION['rol'] === 'Gerente') {
            $rol = $_POST['rol'];
        }

        // Verificar si ya existe el usuario
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('El usuario ya existe');window.location.href='../index.html';</script>";
            exit;
        }

        // Crear usuario
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, clave, rol, correo, telefono) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $usuario, $claveHash, $rol, $correo, $telefono);

        if ($stmt->execute()) {
            echo "<script>alert('Usuario registrado correctamente');window.location.href='../index.html';</script>";
        } else {
            echo "<script>alert('Error al registrar: " . $stmt->error . "');window.location.href='../index.html';</script>";
        }
        exit;
    }
}
?>
