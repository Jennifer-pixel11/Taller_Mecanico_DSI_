<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
  header("Location: index.html");
  exit;
}

$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
date_default_timezone_set('America/El_Salvador');
$hora = date("d/m/Y H:i:s");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Principal - Taller Mecánico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/Taller_Mecanico_DSI_/static/css/style.css">
</head>
<body>
  <?php include 'components/navbar.php'; ?>  

  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h4">Bienvenido, <?= htmlspecialchars($usuario) ?> 👋</h1>
        <p class="mb-0">Rol: <strong><?= htmlspecialchars($rol) ?></strong> | Hora actual: <?= $hora ?></p>
      </div>
    </div>

    <div class="row g-4">
      <?php if ($rol === 'Gerente' || $rol === 'Mecánico'): ?>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/inventario.png" alt="Inventario" class="img-fluid">
              <h5 class="card-title">Inventario</h5>
              <a href="/Taller_Mecanico_DSI_/views/InventarioView.php" class="btn btn-outline-primary w-100">Gestionar</a>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/servicios.png" alt="Servicios" class="img-fluid">
              <h5 class="card-title">Servicios</h5>
              <a href="/Taller_Mecanico_DSI_/views/ServicioView.php" class="btn btn-outline-warning w-100">Ver Servicios</a>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/proveedor.png" alt="Proveedor" class="img-fluid">
              <h5 class="card-title">Proveedores</h5>
              <a href="/Taller_Mecanico_DSI_/views/ProveedorView.php" class="btn btn-outline-warning w-100">Proveedor</a>
            </div>
          </div>
        </div>

      <?php endif; ?>

      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="public/citas.png" alt="Citas" class="img-fluid">
            <h5 class="card-title">Citas</h5>
            <a href="/Taller_Mecanico_DSI_/views/CitaView.php" class="btn btn-outline-success w-100">Agendar</a>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="public/notificaciones.png" alt="Notificaciones" class="img-fluid">
            <h5 class="card-title">Notificaciones</h5>
            <a href="/Taller_Mecanico_DSI_/views/NotificacionView.php" class="btn btn-outline-info w-100">Enviar</a>
          </div>
        </div>
      </div>

      <?php if ($rol === 'Visitante'): ?>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/servicios.png" alt="Solicitar" class="img-fluid">
              <h5 class="card-title">Solicitar Servicio</h5>
              <a href="/Taller_Mecanico_DSI_/model/SolicitarServicio.php" class="btn btn-outline-warning w-100">Solicitar</a>
            </div>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
</body>
</html>
