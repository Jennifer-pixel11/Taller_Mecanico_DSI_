<?php
// model/Proveedor.php

$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Registrar proveedor
if (isset($_POST['agregarProveedor'])) {
    $nombre = $_POST['nombre'];
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $direccion = $_POST['direccion'];
    $rubro = $_POST['rubro'];

    $conexion->query("INSERT INTO proveedor_insumos (nombre, nombre_contacto, telefono, correo_electronico, direccion, rubro) 
                      VALUES ('$nombre', '$nombre_contacto', '$telefono', '$correo_electronico', '$direccion', '$rubro')");
    header("Location: Proveedor.php");
    exit;
}

// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM proveedor_insumos WHERE id_proveedor = $id");
    header("Location: Proveedor.php");
    exit;
}

// Obtener proveedores
$resultado = $conexion->query("SELECT * FROM proveedor_insumos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Proveedores</title>
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
    <h2 class="text-center mb-4">Registrar Proveedor</h2>
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <!-- Formulario -->
    <div class="card mb-4">
      <div class="card-header">Nuevo Proveedor</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Nombre del Proveedor</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nombre de contacto</label>
            <input type="text" name="nombre_contacto" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo_electronico" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Rubro</label>
            <input type="text" name="rubro" class="form-control" required>
          </div>
          <button type="submit" name="agregarProveedor" class="btn btn-success">Guardar</button>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Nombre de contacto</th>
          <th>Teléfono</th>
          <th>Correo electrónico</th>
          <th>Dirección</th>
          <th>Rubro</th>
          <th>Estado</th>
          <th>Fecha de registro</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $fila['id_proveedor'] ?></td>
          <td><?= $fila['nombre'] ?></td>
          <td><?= $fila['nombre_contacto'] ?></td>
          <td><?= $fila['telefono'] ?></td>
          <td><?= $fila['correo_electronico'] ?></td>
          <td><?= $fila['direccion'] ?></td>
          <td><?= $fila['rubro'] ?></td>
          <td><?= $fila['estado'] ?></td>
          <td><?= $fila['fecha_registro'] ?></td>
          <td>
            <a href="?eliminar=<?= $fila['id_proveedor'] ?>" onclick="return confirm('¿Eliminar este Proveedor?')" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
