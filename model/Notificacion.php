<?php
// model/Notificacion.php

$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Insertar notificación
if (isset($_POST['agregar'])) {
    $destinatario = $_POST['destinatario'];
    $mensaje = $_POST['mensaje'];
    $conexion->query("INSERT INTO notificaciones (destinatario, mensaje) VALUES ('$destinatario', '$mensaje')");
    header("Location: Notificacion.php");
    exit;
}

// Eliminar notificación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM notificaciones WHERE id = $id");
    header("Location: Notificacion.php");
    exit;
}

// Obtener notificaciones
$notificaciones = $conexion->query("SELECT * FROM notificaciones ORDER BY fecha_envio DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Notificaciones</title>
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
    <h2 class="text-center mb-4">Envio de notificaciones</h2>
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <!-- Formulario -->
    <div class="card mb-4">
      <div class="card-header">Nueva Notificación</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Destinatario</label>
            <input type="text" name="destinatario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="3" required></textarea>
          </div>
          <button type="submit" name="agregar" class="btn btn-success">Enviar</button>
        </form>
      </div>
    </div>

    <!-- Tabla de notificaciones -->
    <table class="table table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Destinatario</th>
          <th>Mensaje</th>
          <th>Fecha de Envío</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php while($n = $notificaciones->fetch_assoc()): ?>
        <tr>
          <td><?= $n['id'] ?></td>
          <td><?= $n['destinatario'] ?></td>
          <td><?= $n['mensaje'] ?></td>
          <td><?= date("d/m/Y H:i", strtotime($n['fecha_envio'])) ?></td>
          <td>
            <a href="?eliminar=<?= $n['id'] ?>" onclick="return confirm('¿Eliminar esta notificación?')" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
