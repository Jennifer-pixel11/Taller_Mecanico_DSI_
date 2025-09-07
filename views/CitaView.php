<?php
include '../model/Cita.php';
include '../components/navbar.php';
?>
<head>
  <title>Citas</title>
</head>
<div class="container py-5">
  <h2 class="text-center mb-4">Agendar Citas</h2>

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
      <?php while ($cita = $citas->fetch_assoc()): ?>
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
</div>