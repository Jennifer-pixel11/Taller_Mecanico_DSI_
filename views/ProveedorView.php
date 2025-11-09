<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) session_start();
include '../components/navbar.php';
require_once '../model/Proveedor.php';
require_once '../model/Conexion.php';

$proveedorModel = new Proveedor();
$proveedores = $proveedorModel->obtenerProveedores();

$proveedorEditar = null;
if (isset($_GET['editar'])) {
    $proveedorEditar = $proveedorModel->obtenerPorId($_GET['editar']);
}
?>

<head>
  <title>Proveedores</title>
</head>

  <div class="container py-5">
    <h2 class="text-center mb-4">Gestión de Proveedores</h2>

    <!-- Botón para abrir el modal -->
    <a href="ProveedorView.php?nuevo=1" class="btn btn-primary mb-3">
        Nuevo Proveedor
    </a>

    <!-- Modal -->
    <div class="modal fade" id="modalProveedor" tabindex="-1" aria-labelledby="modalProveedorLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalProveedorLabel">
              <?= isset($proveedorEditar) ? 'Editar Proveedor' : 'Nuevo Proveedor' ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>

          <div class="modal-body">
            <form action="../controller/ProveedorController.php" method="post" enctype="multipart/form-data" novalidate>
              <?php if (isset($proveedorEditar)): ?>
                <input type="hidden" name="id" value="<?= $proveedorEditar['id_proveedor'] ?>">
              <?php endif; ?>

              <div class="mb-3">
                <label class="form-label">Nombre del Proveedor:<span class="text-danger"> * </span></label>
                <input type="text" name="nombre" placeholder="Empresa Repuestos" class="form-control"
                       value="<?= $proveedorEditar['nombre'] ?? '' ?>" required>
              <div class="invalid-feedback">Este campo es obligatorio.</div>
                      </div>

              <div class="mb-3">
                <label class="form-label">Nombre de contacto:<span class="text-danger"> * </span></label>
                <input type="text" name="nombre_contacto" placeholder="Fulanito Mengano" class="form-control"
                       value="<?= $proveedorEditar['nombre_contacto'] ?? '' ?>" required>
             <div class="invalid-feedback">Este campo es obligatorio.</div>
                      </div>

              <div class="mb-3">
                <label class="form-label">Teléfono:<span class="text-danger"> * </span></label>
                <input type="text" name="telefono" placeholder="xxxx xxxx" class="form-control"
                       value="<?= $proveedorEditar['telefono'] ?? '' ?>" required>
              <div class="invalid-feedback">Este campo es obligatorio.</div>
                      </div>

              <div class="mb-3">
                <label class="form-label">Correo electrónico:<span class="text-danger"> * </span></label>
                <input type="email" name="correo_electronico" placeholder="usuario@example.com" class="form-control"
                       value="<?= $proveedorEditar['correo_electronico'] ?? '' ?>" required>
              <div class="invalid-feedback">Este campo es obligatorio.</div>
                      </div>

              <div class="mb-3">
                <label class="form-label">Dirección:<span class="text-danger"> * </span></label>
                <input type="text" name="direccion" class="form-control" placeholder="Av. Siempre Viva 742"
                       value="<?= $proveedorEditar['direccion'] ?? '' ?>" required>
              <div class="invalid-feedback">Este campo es obligatorio.</div>
                      </div>

              <div class="mb-3">
                <label class="form-label">Rubro:<span class="text-danger"> * </span></label>
                <input type="text" name="rubro" placeholder="repuestos, etc." class="form-control"
                       value="<?= $proveedorEditar['rubro'] ?? '' ?>" required>
             <div class="invalid-feedback">Este campo es obligatorio.</div>
                      </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="<?= isset($proveedorEditar) ? 'editarProveedor' : 'agregarProveedor' ?>"
                        class="btn btn-success">
                    <?= isset($proveedorEditar) ? 'Actualizar' : 'Guardar' ?>
                </button>
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-light">
        <thead class="table-dark">
          <tr>
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
  <?php while ($item = $proveedores->fetch_assoc()): ?>
          <tr>
            <td><?= $item['nombre'] ?></td>
            <td><?= $item['nombre_contacto'] ?></td>
            <td><?= $item['telefono'] ?></td>
            <td><?= $item['correo_electronico'] ?></td>
            <td><?= $item['direccion'] ?></td>
            <td><?= $item['rubro'] ?></td>
            <td><?= $item['estado'] ?></td>
            <td><?= $item['fecha_registro'] ?></td>
            <td>
                <a href="ProveedorView.php?editar=<?= $item['id_proveedor'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>

                <a href="../controller/ProveedorController.php?eliminar=<?= $item['id_proveedor'] ?>" 
                  class="btn btn-sm btn-danger w-100 m-1"
                  onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?')">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Mostrar modal si estamos en modo edición -->
  <?php if (isset($proveedorEditar) || isset($_GET['nuevo'])): ?>
      <script>
        const editarModal = new bootstrap.Modal(document.getElementById('modalProveedor'));
        document.addEventListener('DOMContentLoaded', () => {
            editarModal.show();
        });
      </script>
  <?php endif; ?>
<script src="../static/js/validacionProveedor.js"></script>
