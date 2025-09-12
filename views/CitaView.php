<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Cita.php';
require_once '../model/Conexion.php';

$citaModel = new Cita();
$citas = $citaModel->obtenerCitas();

$citaEditar = null;
if (isset($_GET['editar'])) {
    $citaEditar = $citaModel->obtenerCitaPorId($_GET['editar']);
}

$conn = Conexion::conectar();

include '../components/navbar.php';
?>
<head>
  <title>Citas</title>
</head>
<div class="container py-5">
  <h2 class="text-center mb-4"><?= $citaEditar ? "Editar Cita" : "Agendar Citas" ?></h2>

  <!-- Formulario -->
  <div class="card mb-4">
    <div class="card-header"><?= $citaEditar ? "Editar Cita" : "Nueva Cita" ?></div>
    <div class="card-body">
      <form method="post" action="../controller/CitaController.php">
        <input type="hidden" name="id" value="<?= $citaEditar['id'] ?? '' ?>">

        <!-- Cliente -->
        <div class="mb-3">
          <label class="form-label">Cliente</label>
          <select name="cliente_id" class="form-select" required>
            <option value="">Seleccione un cliente</option>
            <?php
            $sql = "SELECT id, nombre FROM clientes";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $selected = ($citaEditar && $citaEditar['cliente_id'] == $row['id']) ? "selected" : "";
                echo "<option value='".$row['id']."' $selected>".$row['nombre']."</option>";
            }
            ?>
          </select>
        </div>

        <!-- Vehículo -->
        <div class="mb-3">
          <label class="form-label">Vehículo</label>
          <select name="vehiculo_id" class="form-select" required>
            <option value="">Seleccione un vehículo</option>
            <?php
            $sql = "SELECT v.id, CONCAT(v.placa, ' - ', v.marca, ' ', v.modelo) AS vehiculo, c.nombre AS cliente
                    FROM vehiculos v
                    INNER JOIN clientes c ON v.cliente = c.id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $selected = ($citaEditar && $citaEditar['vehiculo_id'] == $row['id']) ? "selected" : "";
                echo "<option value='".$row['id']."' $selected>".$row['vehiculo']." (".$row['cliente'].")</option>";
            }
            ?>
          </select>
        </div>

        <!-- Servicio -->
        <div class="mb-3">
          <label class="form-label">Servicio</label>
          <select name="servicio_id" class="form-select" required>
            <option value="">Seleccione un servicio</option>
            <?php
            $sql = "SELECT id, nombre FROM servicios_catalogo";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $selected = ($citaEditar && $citaEditar['servicio_id'] == $row['id']) ? "selected" : "";
                echo "<option value='".$row['id']."' $selected>".$row['nombre']."</option>";
            }
            ?>
          </select>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
          <label class="form-label">Fecha</label>
          <input type="date" name="fecha" class="form-control"
                 value="<?= $citaEditar['fecha'] ?? '' ?>" required>
        </div>

        <!-- Hora -->
        <div class="mb-3">
          <label class="form-label">Hora</label>
          <input type="time" name="hora" class="form-control"
                 value="<?= $citaEditar['hora'] ?? '' ?>" required>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" class="form-control" rows="3" required><?= $citaEditar['descripcion'] ?? '' ?></textarea>
        </div>

        <?php if ($citaEditar): ?>
          <button type="submit" name="editar" class="btn btn-warning">Actualizar Cita</button>
          <a href="CitaView.php" class="btn btn-secondary">Cancelar</a>
        <?php else: ?>
          <button type="submit" name="agendar" class="btn btn-success">Guardar Cita</button>
        <?php endif; ?>
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
        <th>Estado</th>
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
          <td><?= $cita['estado'] ?></td>
          <td>
            <a href="?editar=<?= $cita['id'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>
            <a href="../controller/CitaController.php?eliminar=<?= $cita['id'] ?>" 
               onclick="return confirm('¿Eliminar esta cita?')" 
               class="btn btn-sm btn-danger w-100 m-1">Eliminar</a>
            <?php if ($cita['estado'] != 'Completada'): ?>
              <a href="../controller/CitaController.php?completar=<?= $cita['id'] ?>" 
                 onclick="return confirm('¿Marcar como completada? Se generará un servicio.')" 
                 class="btn btn-sm btn-success w-100 m-1">Completar</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
