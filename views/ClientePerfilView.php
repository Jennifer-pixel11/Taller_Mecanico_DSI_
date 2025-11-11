<?php
session_start();
require_once '../model/Conexion.php';

// Si no ha iniciado sesión, lo manda al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit;
}

$usuario = $_SESSION['usuario'];

// Conexión
$conn = Conexion::conectar();

// Obtener datos del cliente desde la tabla usuarios
$stmt = $conn->prepare("SELECT usuario, correo, telefono, rol FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
// 2️⃣ Obtener datos del cliente (vinculado por correo)
$stmtCliente = $conn->prepare("SELECT nombre, telefono, correo, direccion FROM clientes WHERE correo = ?");
$stmtCliente->bind_param("s", $cliente['correo']);
$stmtCliente->execute();
$resultCliente = $stmtCliente->get_result();
$datosCliente = $resultCliente->fetch_assoc();

// 3️⃣ Obtener vehículos del cliente (usando el mismo correo para relacionar)
$stmtVehiculos = $conn->prepare("
    SELECT v.placa, v.marca, v.modelo
    FROM vehiculos v
    INNER JOIN clientes c ON v.cliente = c.id
    WHERE c.correo = ?
");
$stmtVehiculos->bind_param("s", $cliente['correo']);
$stmtVehiculos->execute();
$vehiculos = $stmtVehiculos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="../public/logotipo.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="../static/css/style.css">
  <link rel="stylesheet" type="text/css" href="../public/styles.css">
</head>
<body class="bg-light">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="barnav">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="../public/logotipo.png" alt="Logo" height="70"></a>
        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuExpandible" aria-controls="menuExpandible" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
   <!-- Menú expandible -->
        <div class="collapse navbar-collapse" id="menuExpandible">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="../views/ClientePerfilView.php">INICIO</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/vehiculosClienteView.php">MIS VEHICULOS</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/ServiciosClienteView.php">MIS SERVICIOS</a></li>
           </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a href="../controller/UsuarioController.php?accion=logout" class="btn btn-danger">Cerrar sesión</a></li>
          </ul>
         <!--  <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Buscar">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
          </form> -->
        </div>
      </div>
  </nav>

  <div class="container mt-4">
    <div class="card bg-white p-2 text-dark bg-opacity-15 border-0 rounded-4 w-100">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
            
            <!-- Información del Usuario -->
            <div class="mb-3 mb-md-0">
                <h4 class="tittle">👋 Bienvenido/a, <?php echo htmlspecialchars($usuario); ?>!</h4>
                <h6 class="mb-0">¡Nos alegra tenerte de vuelta en el sistema de gestión del taller! 🎉</h6>
            </div>
        </div>
    </div>
</div>
 <!-- PERFIL DEL CLIENTE -->
<div class="container py-5">
  <div class="row justify-content-center mb-4">

    <!-- CARD PERFIL DEL CLIENTE -->
    <div class="col-md-5">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white text-center">
          <h4>Perfil del Cliente</h4>
        </div>
        <div class="card-body text-center">
          <img src="../public/cliente.png" alt="Usuario" class="mb-3 rounded-circle">
          <h5 class="card-title"><?= htmlspecialchars($cliente['usuario']); ?></h5>
          <p class="card-text"><strong>Correo:</strong> <?= htmlspecialchars($cliente['correo']); ?></p>
          <p class="card-text"><strong>Teléfono:</strong> <?= htmlspecialchars($cliente['telefono'] ?? 'No registrado'); ?></p>
          <p class="card-text"><strong>Rol:</strong> <?= htmlspecialchars($cliente['rol']); ?></p>
          <hr>
          <a href="#" class="btn btn-primary">Editar perfil</a>
        </div>
      </div>
    </div>

    <!-- CARD DATOS DEL CLIENTE -->
    <div class="col-md-5">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white text-center">
          <h4>Datos del Cliente</h4>
        </div>
        <div class="card-body text-center">
          <img src="../public/cliente.png" alt="Usuario" class="mb-3 rounded-circle">
          <h5 class="card-title"><strong>Nombre: </strong><?= htmlspecialchars($datosCliente['nombre'] ?? $cliente['usuario']); ?></h5>
          <p><strong>Correo:</strong> <?= htmlspecialchars($datosCliente['correo'] ?? $cliente['correo']); ?></p>
          <p><strong>Teléfono:</strong> <?= htmlspecialchars($datosCliente['telefono'] ?? $cliente['telefono']); ?></p>
          <p><strong>Dirección:</strong> <?= htmlspecialchars($datosCliente['direccion'] ?? 'No registrada'); ?></p>
          <hr>
          <a href="#" class="btn btn-primary">Editar perfil</a>
        </div>
      </div>
    </div>

  </div>
</div>


</body>
</html>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
