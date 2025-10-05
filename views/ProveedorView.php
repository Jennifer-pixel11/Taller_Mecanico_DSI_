<?php 
include("../controller/ProveedorController.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Proveedores</title>

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="/Taller_Mecanico_DSI_/public/logotipo.png" type="image/png">
  <link rel="stylesheet" href="/Taller_Mecanico_DSI_/static/css/style.css">
  <link rel="stylesheet" href="/Taller_Mecanico_DSI_/public/styles.css">
</head>
<body class="bg-light">
  <?php include __DIR__ . '/../components/navbar.php'; ?>

  <div class="container py-5">
    <h2 class="text-center mb-4">Gestión de Proveedores</h2>

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalProveedor">
      Nuevo Proveedor
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalProveedor" tabindex="-1" aria-labelledby="modalProveedorLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalProveedorLabel">
              <?= isset($editarProveedor) ? 'Editar Proveedor' : 'Nuevo Proveedor' ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>

          <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
              <?php if (isset($editarProveedor)): ?>
                <input type="hidden" name="id" value="<?= $editarProveedor['id_proveedor'] ?>">
              <?php endif; ?>

              <div class="mb-3">
                <label class="form-label">Nombre del Proveedor:<span class="text-danger"> * </span></label>
                <input type="text" name="nombre" placeholder="Empresa Repuestos" class="form-control"
                       value="<?= $editarProveedor['nombre'] ?? '' ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Nombre de contacto:<span class="text-danger"> * </span></label>
                <input type="text" name="nombre_contacto" placeholder="Fulanito Mengano" class="form-control"
                       value="<?= $editarProveedor['nombre_contacto'] ?? '' ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Teléfono:<span class="text-danger"> * </span></label>
                <input type="text" name="telefono" placeholder="xxxx xxxx" class="form-control"
                       value="<?= $editarProveedor['telefono'] ?? '' ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Correo electrónico:<span class="text-danger"> * </span></label>
                <input type="email" name="correo_electronico" placeholder="usuario@example.com" class="form-control"
                       value="<?= $editarProveedor['correo_electronico'] ?? '' ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Dirección:<span class="text-danger"> * </span></label>
                <input type="text" name="direccion" class="form-control" placeholder="Av. Siempre Viva 742"
                       value="<?= $editarProveedor['direccion'] ?? '' ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Rubro:<span class="text-danger"> * </span></label>
                <input type="text" name="rubro" placeholder="repuestos, etc." class="form-control"
                       value="<?= $editarProveedor['rubro'] ?? '' ?>" required>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="<?= isset($editarProveedor) ? 'editarProveedor' : 'agregarProveedor' ?>"
                        class="btn btn-success">
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
              <!-- Para editar: recarga con ?editar=ID y mostramos el modal al cargar -->
              <a href="?editar=<?= $item['id_proveedor'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>

              <!-- CORREGIDO: $item en lugar de $fila -->
              <a href="?eliminar=<?= $item['id_proveedor'] ?>" class="btn btn-sm btn-danger w-100 m-1"
                 onclick="return confirm('¿Eliminar proveedor?')">Eliminar</a>
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

  <!-- JS Bootstrap (necesario para el menú hamburguesa y los modales) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
