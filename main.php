<?php
include './components/navbar.php';

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
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="public/logotipo.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="./static/css/style.css">
  <link rel="stylesheet" type="text/css" href="./public/styles.css">
</head>

  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h4">Bienvenido, <?= htmlspecialchars($usuario) ?> 👋</h1>
        <p class="mb-0">Rol: <strong><?= htmlspecialchars($rol) ?></strong> | Hora actual: <?= $hora ?></p>
        </ul>
        
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0"></ul>
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
              <a href="./views/ClienteView.php" class="btn btn-outline-secondary w-100">Ir a Clientes</a>
            </div>
          </div>
        </div>

        <!----Vehiculos card-->
         <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/vehiculo.png" alt="Vehículos" class="img-fluid">
              <h5 class="card-title">Vehículos</h5>
              <a href="./views/VehiculoView.php" class="btn btn-outline-dark w-100">Ir a Vehículos</a>
            </div>
          </div>
        </div>

          <!----Servicios card-->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/servicios.png" alt="Servicios" class="img-fluid">
              <h5 class="card-title">Servicios</h5>
              <a href="./views/ServicioView.php" class="btn btn-outline-danger w-100">Ver Servicios</a>
            </div>
          </div>
        </div>

        <!----Citas card-->
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="public/citas.png" alt="Citas" class="img-fluid">
            <h5 class="card-title">Citas</h5>
            <a href="./views/CitaView.php" class="btn btn-outline-success w-100">Agendar</a>
          </div>
        </div>
      </div>

        <!--Inventario card-->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/inventario.png" alt="Inventario" class="img-fluid">
              <h5 class="card-title">Inventario</h5>
              <a href="/Taller_Mecanico_DSI_/model/Inventario.php" class="btn btn-outline-primary w-100">Gestionar</a>
            </div>
          </div>
        </div>

        <!----Proveedores card-->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/proveedor.png" alt="Proveedor" class="img-fluid">
              <h5 class="card-title">Proveedores</h5>
              <a href="./views/ProveedorView.php" class="btn btn-outline-warning w-100">Proveedor</a>
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
            <a href="./views/NotificacionView.php" class="btn btn-outline-info w-100">Enviar</a>
          </div>
        </div>
      </div>

      <?php if ($rol === 'Visitante'): ?>
        <!----Vehiculos card-->
         <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/vehiculo.png" alt="Vehículos" class="img-fluid">
              <h5 class="card-title">Vehículos</h5>
              <a href="./views/VehiculoView.php" class="btn btn-outline-dark w-100">Ir a Vehículos</a>
            </div>
          </div>
        </div>

          <!----Servicios card-->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <img src="public/servicios.png" alt="Servicios" class="img-fluid">
              <h5 class="card-title">Servicios</h5>
              <a href="./views/ServicioView.php" class="btn btn-outline-danger w-100">Ver Servicios</a>
            </div>
          </div>
        </div>

        <!----Citas card-->
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="public/citas.png" alt="Citas" class="img-fluid">
            <h5 class="card-title">Citas</h5>
            <a href="./views/CitaView.php" class="btn btn-outline-success w-100">Agendar</a>
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