<?php
// model/Inventario.php

// Conexión
$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Agregar producto
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $conexion->query("INSERT INTO inventario (nombre, descripcion, cantidad) VALUES ('$nombre', '$descripcion', '$cantidad')");
    header("Location: Inventario.php");
    exit;
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM inventario WHERE id = $id");
    header("Location: Inventario.php");
    exit;
}

// Editar producto
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $conexion->query("UPDATE inventario SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad' WHERE id=$id");
    header("Location: Inventario.php");
    exit;
}

// Obtener producto para editar
$editarProducto = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM inventario WHERE id = $id");
    $editarProducto = $resultado->fetch_assoc();
}

// Obtener lista de productos
$productos = $conexion->query("SELECT * FROM inventario");

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inventario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Inventario</h2>
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
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <!-- Formulario -->
    <div class="card mb-4">
      <div class="card-header">
        <?= $editarProducto ? "Editar Producto" : "Agregar Producto" ?>
      </div>
      <div class="card-body">
        <form method="post">
          <?php if ($editarProducto): ?>
            <input type="hidden" name="id" value="<?= $editarProducto['id'] ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $editarProducto['nombre'] ?? '' ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= $editarProducto['descripcion'] ?? '' ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $editarProducto['cantidad'] ?? '' ?>" required>
          </div>
          <button type="submit" name="<?= $editarProducto ? 'editar' : 'agregar' ?>" class="btn btn-success">
            <?= $editarProducto ? 'Actualizar' : 'Guardar' ?>
          </button>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($item = $productos->fetch_assoc()): ?>
        <tr>
          <td><?= $item['id'] ?></td>
          <td><?= $item['nombre'] ?></td>
          <td><?= $item['descripcion'] ?></td>
          <td><?= $item['cantidad'] ?></td>
          <td>
            <a href="?editar=<?= $item['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="?eliminar=<?= $item['id'] ?>" onclick="return confirm('¿Eliminar este producto?')" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
