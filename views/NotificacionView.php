<?php
include '../model/Notificacion.php';
include '../components/navbar.php';
?>

<div class="container py-5">
  <h2 class="text-center mb-4">Envio de notificaciones</h2>

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
      <?php while ($n = $notificaciones->fetch_assoc()): ?>
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