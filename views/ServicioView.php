<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Servicio.php';
require_once '../model/Conexion.php';

$servicioModel = new Servicio();
$servicios = $servicioModel->obtenerServicios();

$servicioEditar = null;
if (isset($_GET['editar'])) {
    $servicioEditar = $servicioModel->obtenerPorId($_GET['editar']);
}

$conn = Conexion::conectar();

include '../components/navbar.php';
?>
<head>
  <title>Servicios</title>
</head>
<div class="container py-5">
  <h2 class="text-center mb-4"><?= $servicioEditar ? "Editar Servicio" : "Registrar Servicio" ?></h2>

  <!-- Formulario -->
  <div class="card mb-4">
    <div class="card-header"><?= $servicioEditar ? "Editar Servicio" : "Nuevo Servicio" ?></div>
    <div class="card-body">
      <form method="post" action="../controller/ServicioController.php" novalidate>
        <input type="hidden" name="id" value="<?= $servicioEditar['id'] ?? '' ?>">

        <!-- Vehículo -->
        <div class="mb-3">
          <label class="form-label">Vehículo<span class="text-danger"> * </span></label>
          <select name="vehiculo_id" class="form-select" required>
            <option value="">Seleccione un vehículo</option>
            <?php
            $sql = "SELECT v.id, CONCAT(v.placa, ' - ', v.marca, ' ', v.modelo) AS vehiculo, c.nombre AS cliente
                    FROM vehiculos v
                    INNER JOIN clientes c ON v.cliente = c.id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $selected = ($servicioEditar && $servicioEditar['vehiculo_id'] == $row['id']) ? "selected" : "";
                echo "<option value='".$row['id']."' $selected>".$row['vehiculo']." (".$row['cliente'].")</option>";
            }
            ?>
          </select>
          <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
          <label class="form-label">Ingresa una Descripción del servicio que se brindará: <span class="text-danger"> * </span></label>
          <textarea name="descripcion" placeholder="Servicio de mantenimiento preventivo,..." class="form-control" rows="3" required><?= $servicioEditar['descripcion'] ?? '' ?></textarea>
          <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
          <label class="form-label">Fecha<span class="text-danger"> * </span></label>
          <input type="date" name="fecha" class="form-control"
                 value="<?= $servicioEditar['fecha'] ?? '' ?>" required>
        <div class="invalid-feedback">Este campo es obligatorio.</div>
                </div>

        <!-- Costo -->
        <div class="mb-3">
          <label class="form-label">Ingresa el Costo Total del servicio: <span class="text-danger"> * </span></label>
          <input type="number" step="0.01" name="costo" placeholder="$00.00 " class="form-control"
                 value="<?= $servicioEditar['costo'] ?? '' ?>" required>
        <div class="invalid-feedback">Este campo es obligatorio.</div>
                </div>

        <?php if ($servicioEditar): ?>
          <button type="submit" name="editar" class="btn btn-warning">Actualizar Servicio</button>
     
          <a href="ServicioView.php" class="btn btn-secondary">Cancelar</a>
        <?php else: ?>
          <button type="submit" name="guardar" class="btn btn-success">Guardar Servicio</button>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Tabla de Servicios -->
  <table class="table table-bordered table-hover table-light">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Vehículo</th>
        <th>Descripción</th>
        <th>Fecha</th>
        <th>Costo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($servicio = $servicios->fetch_assoc()): ?>
        <tr>
          <td><?= $servicio['id'] ?></td>
          <td><?= $servicio['cliente'] ?></td>
          <td><?= $servicio['vehiculo'] ?></td>
          <td><?= $servicio['descripcion'] ?></td>
          <td><?= $servicio['fecha'] ?></td>
          <td>$<?= number_format($servicio['costo'], 2) ?></td>
          <td>
           <!-- generar el comprobante-->
            <a href="../controller/ComprobanteController.php?generar=<?= $servicio['id'] ?>&total=<?= $servicio['costo'] ?>" 
               class="btn btn-sm btn-info w-100 m-1">Generar Comprobante</a>

            <!-- Editar -->
            <a href="?editar=<?= $servicio['id'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>

            <!-- Eliminar -->
            <a href="../controller/ServicioController.php?eliminar=<?= $servicio['id'] ?>" 
               onclick="return confirm('¿Eliminar este servicio?')" 
               class="btn btn-sm btn-danger w-100 m-1">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <div class="mb-3">
  <a href="/Taller_Mecanico_DSI_/views/ServicioReporteView.php" class="btn btn-outline-primary" target="_blank">
    📊 Informe General de Servicios
  </a>
</div>

</div>
<script src="../static/js/validacionServicio.js"></script>