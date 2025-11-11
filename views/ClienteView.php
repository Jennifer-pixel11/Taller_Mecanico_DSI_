<?php
require_once '../model/Cliente.php';
require_once '../model/Usuario.php';
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
      <form method="post" action="../controller/ClienteController.php" novalidate>
        <input type="hidden" name="id" value="<?= $clienteEditar['id'] ?? '' ?>">
        <div class="mb-3">
          <label class="form-label">Ingresa el Nombre completo del cliente: <span class="text-danger"> * </span></label>
          <input type="text" id="nombre"  name="nombre" placeholder="Fulanito Mengano " class="form-control" 
                 value="<?= $clienteEditar['nombre'] ?? '' ?>" required>
          <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Ingresa el numero de Telefono del cliente: <span class="text-danger"> * </span></label>
          <input type="text" id="telefono" name="telefono" placeholder="xxxx xxxx " class="form-control" 
                 value="<?= $clienteEditar['telefono'] ?? '' ?>">
          <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Ingresa la dirección e-mail del cliente: <span class="text-danger"> * </span></label>
          <input type="email" id="correo" name="correo" placeholder="usuario@example.com" class="form-control" 
                 value="<?= $clienteEditar['correo'] ?? '' ?>" required>
          <div class="invalid-feedback">Este campo es obligatorio.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Ingresa la ubicación completa y actual del cliente: <span class="text-danger"> * </span></label>
          <textarea id="direccion" name="direccion" placeholder="Av. Siempre Viva 742" class="form-control" rows="2"><?= $clienteEditar['direccion'] ?? '' ?></textarea>
          <div class="invalid-feedback">Este campo es obligatorio.</div>
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
        <th>Descripcion de usuario</th>
      </tr>
    </thead>
 <?php
// Conexión rápida
include_once("../model/Conexion.php");
$conn = Conexion::conectar();

// Traer clientes con info de usuario en una sola consulta
$sql = "SELECT c.*, u.usuario AS usuario_sistema, u.clave AS clave_temporal
        FROM clientes c
        LEFT JOIN usuarios u ON u.correo = c.correo";
$result = $conn->query($sql);
?>

<tbody>
<?php 
include_once("../model/Conexion.php");
$conn = Conexion::conectar();

while ($cliente = $clientes->fetch_assoc()):
    $correo = $cliente['correo'];
    $sqlUser = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resUser = $conn->query($sqlUser);
    $usuarioExistente = $resUser->num_rows > 0;
?>
<tr>
    <td><?= $cliente['id'] ?></td>
    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
    <td><?= htmlspecialchars($cliente['correo']) ?></td>
    <td><?= htmlspecialchars($cliente['direccion']) ?></td>
    <td>
        <a href="?editar=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar Cliente</a>
        <a href="../controller/ClienteController.php?eliminar=<?= $cliente['id'] ?>" 
           onclick="return confirm('¿Eliminar este cliente?')" 
           class="btn btn-sm btn-danger w-100 m-1">Eliminar Cliente</a>
    </td>
    <td>
        <?php if ($usuarioExistente): ?>
            <span class="text-success fw-bold">Usuario existente ✅</span><br>

            <?php if (isset($_GET['usuario']) && $_GET['usuario'] === $correo): ?>
                <p class="mb-1"><strong>Nombre de usuario:</strong> <?= htmlspecialchars($_GET['usuario']); ?></p>
                <p class="mb-1"><strong>Contraseña temporal:</strong> <?= htmlspecialchars($_GET['clave']); ?></p>
                <small class="text-muted usuario-temporal">(Recuerda enviarle estos datos al cliente)</small>
            <?php endif; ?>

        <?php else: ?>
            <form method="post" action="../controller/ClienteController.php">
                <input type="hidden" name="correo" value="<?= htmlspecialchars($cliente['correo']); ?>">
                <input type="hidden" name="telefono" value="<?= htmlspecialchars($cliente['telefono']); ?>">
                 <span class="text-danger fw-bold">Cliente sin Usuario ❌⚠️</span><br>
            </form>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>


  </table>
</div>
<script src="../static/js/validacionCliente.js"></script>

