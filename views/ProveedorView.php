<?php 
include("../controller/ProveedorController.php");
include '../components/navbar.php';
?>
<head>
  <title>Proveedores</title>
</head>
<div class="container py-5">
  <h2 class="text-center mb-4">Gestión de Proveedores</h2>

  <!-- Botón para mostrar/ocultar formulario 
    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formularioProveedor">+ Agregar Proveedor</button>-->
  <!-- Botón para abrir el modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalProveedor">
    Nuevo Proveedor
  </button>
  <!-- Modal -->
  <div class="modal fade" id="modalProveedor" tabindex="-1" aria-labelledby="modalProveedorLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProveedorLabel"><?= isset($editarProveedor) ? 'Editar Proveedor' : 'Nuevo Proveedor' ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
            <?php if (isset($editarProveedor)): ?>
              <input type="hidden" name="id" value="<?= $editarProveedor['id_proveedor'] ?>">
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Nombre del Proveedor</label>
              <input type="text" name="nombre" class="form-control" value="<?= $editarProveedor['nombre'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Nombre de contacto</label>
              <input type="text" name="nombre_contacto" class="form-control" value="<?= $editarProveedor['nombre_contacto'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Teléfono</label>
              <input type="text" name="telefono" class="form-control" value="<?= $editarProveedor['telefono'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Correo electrónico</label>
              <input type="email" name="correo_electronico" class="form-control" value="<?= $editarProveedor['correo_electronico'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" value="<?= $editarProveedor['direccion'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Rubro</label>
              <input type="text" name="rubro" class="form-control" value="<?= $editarProveedor['rubro'] ?? '' ?>" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" name="<?= isset($editarProveedor) ? 'editarProveedor' : 'agregarProveedor' ?>" class="btn btn-success">
                <?= isset($editarProveedor) ? 'Actualizar' : 'Guardar' ?>
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
      <?php while ($item = $resultado->fetch_assoc()): ?>
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
             <!-- Botón para editar proveedor -->
              <button 
                type="button" 
                class="btn btn-sm btn-warning w-100 m-1" 
                data-bs-toggle="modal" 
                data-bs-target="#modalProveedor" 
                onclick="window.location.href='?editar=<?= $item['id_proveedor'] ?>'">
                Editar
              </button>
            <a href="?eliminar=<?= $fila['id_proveedor'] ?>" class="btn btn-sm btn-danger w-100 m-1" onclick="return confirm('¿Eliminar proveedor?')">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
   </div>
</div>

<!-- Mostrar modal si estamos en modo edición -->
<?php if (isset($editarProveedor)): ?>
  <script>
    const editarModal = new bootstrap.Modal(document.getElementById('modalProveedor'));
    window.addEventListener('load', () => editarModal.show());
  </script>
<?php endif; ?>