<?php include("../controller/ProveedorController.php"); ?>

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
    <h2 class="text-center mb-4">Gestión de Proveedores</h2>
    <a href="../main.php" class="btn btn-secondary mb-3">Volver al Panel</a>
    
    <!-- Botón para mostrar/ocultar formulario -->
    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formularioProveedor">+ Agregar Proveedor</button>

    <!-- Formulario -->
    <div class="collapse" id="formularioProveedor">
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
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Contacto</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Dirección</th>
          <th>Rubro</th>
          <th>Estado</th>
          <th>Registro</th>
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
            <a href="?eliminar=<?= $fila['id_proveedor'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar proveedor?')">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
