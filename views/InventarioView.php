<?php
require_once "../controller/InventarioController.php"; // Controlador
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link href="../public/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
<?php include "../components/navbar.php"; ?>

<div class="container py-5">
    <h2 class="text-center mb-4">Inventario</h2>

    <!-- Botón Agregar / Modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalProducto">
        <?= $editarProducto ? 'Editar Producto' : 'Agregar Producto' ?>
    </button>

    <!-- Modal -->
    <!-- Modal -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="modalProductoLabel">Agregar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <?php if ($editarProducto): ?>
            <input type="hidden" name="id" value="<?= $editarProducto['id'] ?>">
          <?php endif; ?>

          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $editarProducto['nombre'] ?? '' ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= $editarProducto['descripcion'] ?? '' ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $editarProducto['cantidad'] ?? '' ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $editarProducto['precio'] ?? '' ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="id_proveedor" class="form-select">
              <option value="">-- Seleccione --</option>
              <?php while($p = $proveedores->fetch_assoc()): ?>
                <option value="<?= $p['id_proveedor'] ?>" <?= (isset($editarProducto['id_proveedor']) && $editarProducto['id_proveedor'] == $p['id_proveedor']) ? 'selected' : '' ?>>
                  <?= $p['nombre'] ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="<?= $editarProducto ? 'editar' : 'agregar' ?>" class="btn btn-success">
              <?= $editarProducto ? 'Actualizar' : 'Guardar' ?>
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-light">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                    <th>Imagen</th>
                    <th>Fecha Modificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?= $item['nombre'] ?></td>
                    <td><?= $item['descripcion'] ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($item['precio'], 2) ?></td>
                    <td><?= $item['proveedor_nombre'] ?? 'N/D' ?></td>
                    <td><?php if ($item['imagen']): ?><img src="<?= $item['imagen'] ?>" width="50"><?php endif; ?></td>
                    <td><?= $item['fecha_modificacion'] ?></td>
                    <td>
                        <a href="?editar=<?= $item['id'] ?>" class="btn btn-sm btn-warning w-100 m-1">Editar</a>
                        <a href="?eliminar=<?= $item['id'] ?>" onclick="return confirm('¿Eliminar este producto?')" class="btn btn-sm btn-danger w-100 m-1">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../public/bootstrap.bundle.min.js"></script>

<?php if ($editarProducto): ?>
<script>
const editarModal = new bootstrap.Modal(document.getElementById('modalProducto'));
window.addEventListener('load', () => editarModal.show());
</script>
<?php endif; ?>
</body>
</html>
