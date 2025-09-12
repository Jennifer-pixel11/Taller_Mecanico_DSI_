<?php
require_once '../model/Cliente.php';
$clienteModel = new Cliente();
$clientes = $clienteModel->obtenerClientes();


$clienteEditar = null;
if (isset($_GET['editar'])) {
    $clienteEditar = $clienteModel->obtenerPorId($_GET['editar']);
}

// Navbar
include '../components/navbar.php';
?>
<head>
  <title>Clientes</title>
</head>
<div class="container py-5">
  <h2 class="text-center mb-4"><?= $clienteEditar ? "Editar Cliente" : "Registrar Cliente" ?></h2>

  <!-- Formulario -->
  <div class="card mb-4">
    <div class="card-header"><?= $clienteEditar ? "Editar Cliente" : "Nuevo Cliente" ?></div>
    <div class="card-body">
      <form method="post" action="../controller/ClienteController.php">
        <input type="hidden" name="id" value="<?= $clienteEditar['id'] ?? '' ?>">

        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" 
                 value="<?= $clienteEditar['nombre'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="telefono" class="form-control" 
                 value="<?= $clienteEditar['telefono'] ?? '' ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" 
                 value="<?= $clienteEditar['correo'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Dirección</label>
          <textarea name="direccion" class="form-control" rows="2"><?= $clienteEditar['direccion'] ?? '' ?></textarea>
        </div>

        <?php if ($clienteEditar): ?>
          <button type="submit" name="editar" class="btn btn-warning">Actualizar Cliente</button>
          <a href="ClienteView.php" class="btn btn-secondary">Cancelar</a>
        <?php else: ?>
          <button type="submit" name="agregar" class="btn btn-success">Guardar Cliente</button>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Tabla -->
  <table class="table table-bordered table-hover table-light">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Dirección</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($cliente = $clientes->fetch_assoc()): ?>
        <tr>
          <td><?= $cliente['id'] ?></td>
          <td><?= $cliente['nombre'] ?></td>
          <td><?= $cliente['telefono'] ?></td>
          <td><?= $cliente['correo'] ?></td>
          <td><?= $cliente['direccion'] ?></td>
          <td>
            <a href="?editar=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>
            <a href="../controller/ClienteController.php?eliminar=<?= $cliente['id'] ?>" 
               onclick="return confirm('¿Eliminar este cliente?')" 
               class="btn btn-sm btn-danger w-100 m-1">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
