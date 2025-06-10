<?php
// model/Servicio.php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] !== 'Gerente' && $_SESSION['rol'] !== 'Mecánico')) {
  header("Location: ../index.html");
  exit;
}

$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Insertar nuevo servicio
if (isset($_POST['agregar'])) {
    $vehiculo = $_POST['vehiculo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $costo = $_POST['costo'];
    $conexion->query("INSERT INTO servicios (vehiculo, descripcion, fecha, costo) VALUES ('$vehiculo', '$descripcion', '$fecha', '$costo')");
    header("Location: Servicio.php");
    exit;
}

// Eliminar servicio
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM servicios WHERE id = $id");
    header("Location: Servicio.php");
    exit;
}

// Editar servicio
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $vehiculo = $_POST['vehiculo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $costo = $_POST['costo'];
    $conexion->query("UPDATE servicios SET vehiculo='$vehiculo', descripcion='$descripcion', fecha='$fecha', costo='$costo' WHERE id=$id");
    header("Location: Servicio.php");
    exit;
}

// Obtener para editar
$editar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM servicios WHERE id = $id");
    $editar = $resultado->fetch_assoc();
}

// Obtener lista
$servicios = $conexion->query("SELECT * FROM servicios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Servicios</title>
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
    <h2 class="text-center mb-4">Registro de Servicios</h2>
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <!-- Formulario -->
    <div class="card mb-4">
      <div class="card-header"><?= $editar ? "Editar Servicio" : "Agregar Servicio" ?></div>
      <div class="card-body">
        <form method="post">
          <?php if ($editar): ?>
            <input type="hidden" name="id" value="<?= $editar['id'] ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label">Vehículo</label>
            <input type="text" name="vehiculo" class="form-control" value="<?= $editar['vehiculo'] ?? '' ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= $editar['descripcion'] ?? '' ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="<?= $editar['fecha'] ?? '' ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Costo</label>
            <input type="number" step="0.01" name="costo" class="form-control" value="<?= $editar['costo'] ?? '' ?>" required>
          </div>
          <button type="submit" name="<?= $editar ? 'editar' : 'agregar' ?>" class="btn btn-success">
            <?= $editar ? 'Actualizar' : 'Guardar' ?>
          </button>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Vehículo</th>
          <th>Descripción</th>
          <th>Fecha</th>
          <th>Costo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($serv = $servicios->fetch_assoc()): ?>
        <tr>
          <td><?= $serv['id'] ?></td>
          <td><?= $serv['vehiculo'] ?></td>
          <td><?= $serv['descripcion'] ?></td>
          <td><?= $serv['fecha'] ?></td>
          <td>$<?= number_format($serv['costo'], 2) ?></td>
          <td>
            <a href="?editar=<?= $serv['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="?eliminar=<?= $serv['id'] ?>" onclick="return confirm('¿Eliminar este servicio?')" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
