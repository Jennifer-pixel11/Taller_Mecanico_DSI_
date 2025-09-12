<?php
require_once '../model/Vehiculo.php';
require_once '../model/Conexion.php';

$vehiculoModel = new Vehiculo();
$vehiculos = $vehiculoModel->obtenerVehiculos();

// Si estamos editando
$vehiculoEditar = null;
if (isset($_GET['editar'])) {
    $vehiculoEditar = $vehiculoModel->obtenerPorId($_GET['editar']);
}

// Navbar
include '../components/navbar.php';

// Conexión directa para cargar clientes
$conn = Conexion::conectar();
?>
<head>
  <title>Vehículos</title>
</head>
<div class="container py-5">
  <h2 class="text-center mb-4"><?= $vehiculoEditar ? "Editar Vehículo" : "Registrar Vehículo" ?></h2>

  <!-- Formulario -->
  <div class="card mb-4">
    <div class="card-header"><?= $vehiculoEditar ? "Editar Vehículo" : "Nuevo Vehículo" ?></div>
    <div class="card-body">
      <form method="post" action="../controller/VehiculoController.php">
        <input type="hidden" name="id" value="<?= $vehiculoEditar['id'] ?? '' ?>">

        <div class="mb-3">
          <label class="form-label">Placa</label>
          <input type="text" name="placa" class="form-control" 
                 value="<?= $vehiculoEditar['placa'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Cliente</label>
          <select name="cliente" class="form-select" required>
            <option value="">Seleccione un cliente</option>
            <?php
            $sql = "SELECT id, nombre FROM clientes";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $selected = ($vehiculoEditar && $vehiculoEditar['cliente'] == $row['id']) ? "selected" : "";
                echo "<option value='".$row['id']."' $selected>".$row['nombre']."</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Marca</label>
          <input type="text" name="marca" class="form-control" 
                 value="<?= $vehiculoEditar['marca'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Modelo</label>
          <input type="text" name="modelo" class="form-control" 
                 value="<?= $vehiculoEditar['modelo'] ?? '' ?>" required>
        </div>

        <?php if ($vehiculoEditar): ?>
          <button type="submit" name="editar" class="btn btn-warning">Actualizar Vehículo</button>
          <a href="VehiculoView.php" class="btn btn-secondary">Cancelar</a>
        <?php else: ?>
          <button type="submit" name="agregar" class="btn btn-success">Guardar Vehículo</button>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Tabla -->
  <table class="table table-bordered table-hover table-light">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Placa</th>
        <th>Cliente</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($vehiculo = $vehiculos->fetch_assoc()): ?>
        <tr>
          <td><?= $vehiculo['id'] ?></td>
          <td><?= $vehiculo['placa'] ?></td>
          <td><?= $vehiculo['cliente'] ?></td>
          <td><?= $vehiculo['marca'] ?></td>
          <td><?= $vehiculo['modelo'] ?></td>
          <td>
            <a href="?editar=<?= $vehiculo['id'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>
            <a href="../controller/VehiculoController.php?eliminar=<?= $vehiculo['id'] ?>" 
               onclick="return confirm('¿Eliminar este vehículo?')" 
               class="btn btn-sm btn-danger w-100 m-1">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
