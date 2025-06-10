<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Visitante') {
  header("Location: ../index.html");
  exit;
}

require_once 'Conexion.php';

// Insertar si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vehiculo = trim($_POST['vehiculo']);
  $descripcion = trim($_POST['descripcion']);
  $fecha = trim($_POST['fecha']);
  $servicio_id = intval($_POST['servicio_id']);
  $usuario = $_SESSION['usuario'];

  $stmt = $conn->prepare("INSERT INTO citas (vehiculo, descripcion, fecha, servicio_id, usuario) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssis", $vehiculo, $descripcion, $fecha, $servicio_id, $usuario);

  if ($stmt->execute()) {
    echo "<script>alert('Cita registrada exitosamente');window.location.href='../main.php';</script>";
  } else {
    echo "<script>alert('Error al registrar la cita');</script>";
  }
}

// Obtener servicios disponibles
$servicios = $conn->query("SELECT id, descripcion FROM servicios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitar Servicio</title>
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
    <h2 class="text-center mb-4">Solicitar Servicio</h2>
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <div class="card p-4">
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Vehículo</label>
          <input type="text" name="vehiculo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Fecha</label>
          <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Servicio</label>
          <select name="servicio_id" class="form-select" required>
            <option value="">Seleccione un servicio</option>
            <?php while ($row = $servicios->fetch_assoc()): ?>
              <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['descripcion']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success">Agendar Cita</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
