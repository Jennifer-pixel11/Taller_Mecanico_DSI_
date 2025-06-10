<?php
// model/Cita.php

// Conexión
$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Agendar nueva cita
if (isset($_POST['agendar'])) {
    $cliente = $_POST['cliente'];
    $vehiculo = $_POST['vehiculo'];
    $fecha = $_POST['fecha'];
    $conexion->query("INSERT INTO citas (cliente, vehiculo, fecha) VALUES ('$cliente', '$vehiculo', '$fecha')");
    header("Location: Cita.php");
    exit;
}

// Eliminar cita
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM citas WHERE id = $id");
    header("Location: Cita.php");
    exit;
}

// Obtener citas
$citas = $conexion->query("SELECT * FROM citas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Citas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #004e92, #000428);
      color: white;
    }
    .card {
      border-radius: 15px;
      background-color: white;
      color: black;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="text-center mb-4">Agendar Citas</h2>
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <!-- Formulario -->
    <div class="card mb-4">
      <div class="card-header">Nueva Cita</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Nombre del Cliente</label>
            <input type="text" name="cliente" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Vehículo</label>
            <input type="text" name="vehiculo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
          </div>
          <button type="submit" name="agendar" class="btn btn-success">Guardar Cita</button>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Vehículo</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($cita = $citas->fetch_assoc()): ?>
        <tr>
          <td><?= $cita['id'] ?></td>
          <td><?= $cita['cliente'] ?></td>
          <td><?= $cita['vehiculo'] ?></td>
          <td><?= $cita['fecha'] ?></td>
          <td>
            <a href="?eliminar=<?= $cita['id'] ?>" onclick="return confirm('¿Eliminar esta cita?')" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
