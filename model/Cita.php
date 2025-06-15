<?php
// model/Cita.php
session_start();
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Desconocido';

// Conexión
$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Agendar nueva cita
if (isset($_POST['agendar'])) {
    //$cliente = $_POST['cliente'];
    $cliente = $usuario;
    $vehiculo = $_POST['vehiculo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];
    $servicio = $_POST['servicio'];
    $conexion->query("INSERT INTO citas (cliente, vehiculo, fecha, hora, descripcion, servicio, usuario) 
                      VALUES ('$cliente', '$vehiculo', '$fecha', '$hora', '$descripcion', '$servicio', '$usuario')");
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

        <!-- Tabla -->
    <table class="table table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Vehículo</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Servicio</th>
          <th>Descripción</th>
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
          <td><?= $cita['hora'] ?></td>
          <td><?= $cita['servicio'] ?></td>
          <td><?= $cita['descripcion'] ?></td>
          <td>
            <a href="?eliminar=<?= $cita['id'] ?>" onclick="return confirm('¿Eliminar esta cita?')" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <!-- Formulario -->
    <div class="card mb-4">
      <div class="card-header">Nueva Cita</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario) ?>" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Vehículo</label>
            <input type="text" name="vehiculo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="time" name="hora" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Servicio</label>
            <input type="text" name="servicio" class="form-control" required>
          </div>
          <button type="submit" name="agendar" class="btn btn-success">Guardar Cita</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
