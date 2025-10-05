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

<head>
  <title>Panel Principal - Taller Mecánico</title>
</head>

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

        <!---Clientes card--->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/cliente.png" alt="Clientes" class="img-fluid">
              <h5 class="card-title">Clientes</h5>
              <a href="/Taller_Mecanico_DSI_/views/ClienteView.php" class="btn btn-outline-secondary w-100">Ir a Clientes</a>
            </div>
          </div>
        </div>

        <!----Vehiculos card-->
         <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/vehiculo.png" alt="Vehículos" class="img-fluid">
              <h5 class="card-title">Vehículos</h5>
              <a href="/Taller_Mecanico_DSI_/views/VehiculoView.php" class="btn btn-outline-dark w-100">Ir a Vehículos</a>
            </div>
          </div>
        </div>

          <!----Servicios card-->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/servicios.png" alt="Servicios" class="img-fluid">
              <h5 class="card-title">Servicios</h5>
              <a href="/Taller_Mecanico_DSI_/views/ServicioView.php" class="btn btn-outline-danger w-100">Ver Servicios</a>
            </div>
          </div>
        </div>

        <!----Citas card-->
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="public/citas.png" alt="Citas" class="img-fluid">
            <h5 class="card-title">Citas</h5>
            <a href="/Taller_Mecanico_DSI_/views/CitaView.php" class="btn btn-outline-success w-100">Agendar</a>
          </div>
        </div>
      </div>

        <!--Inventario card-->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/inventario.png" alt="Inventario" class="img-fluid">
              <h5 class="card-title">Inventario</h5>
              <a href="/Taller_Mecanico_DSI_/views/InventarioView.php" class="btn btn-outline-primary w-100">Gestionar</a>
            </div>
          </div>
        </div>

        <!----Proveedores card-->
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

       <!----Notificaciones card-->
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

    <!---- Para que le demos color a los botones
    
  btn-outline-primary → azul con borde.

  btn-outline-secondary → gris con borde.

  btn-outline-success → verde con borde.

  btn-outline-danger → rojo con borde.

  btn-outline-warning → amarillo con borde.

  btn-outline-info → celeste con borde.

  btn-outline-light → blanco con borde.

  btn-outline-dark → negro con borde. --->