<?php include '../controller/InventarioController.php';
include '../model/Servicio.php';
include '../components/navbar.php';
?>
<head>
  <title>Servicios</title>
</head>

<div class="container py-5">
  <h2 class="text-center mb-4">Registro de Servicios</h2>

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
      <?php while ($serv = $servicios->fetch_assoc()): ?>
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