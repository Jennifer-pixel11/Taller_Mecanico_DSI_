<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../controller/InventarioController.php';
require_once '../components/navbar.php';
date_default_timezone_set('America/El_Salvador');

function listar_imagenes_dir($relDir) {
  $abs = realpath(__DIR__ . '/../' . $relDir);
  $out = [];
  if ($abs && is_dir($abs)) {
    foreach (scandir($abs) as $f) {
      if ($f === '.' || $f === '..') continue;
      if (preg_match('/\.(png|jpe?g|webp|gif)$/i', $f)) {
        $out[] = $relDir . '/' . $f;
      }
    }
  }
  return $out;
}
$galeria = array_merge(
  listar_imagenes_dir('inventario'), // ojo minúsculas
  listar_imagenes_dir('uploads')
);
sort($galeria);
?>
<head>
  <title>Inventario</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../public/styles.css">
  <script>
    function filtrar() {
      const q = document.getElementById('q').value.toLowerCase();
      document.querySelectorAll('#tabla-inventario tbody tr').forEach(tr=>{
        tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
      });
    }
    function previewFile(input, imgId) {
      const file = input.files[0];
      const img = document.getElementById(imgId);
      if (!img) return;
      if (file) {
        const r = new FileReader();
        r.onload = e => img.src = e.target.result;
        r.readAsDataURL(file);
      }
    }
    function previewSelect(sel, imgId) {
      const img = document.getElementById(imgId);
      if (!img) return;
      img.src = sel.value || '';
    }
    function toggleImagenFuente() {
      const modo = document.querySelector('input[name="modo_imagen"]:checked').value;
      document.getElementById('bloqueSubir').style.display   = (modo==='subir')?'block':'none';
      document.getElementById('bloqueGaleria').style.display = (modo==='galeria')?'block':'none';
    }
  </script>
</head>

<div class="container py-4">
  <h2 class="text-center mb-3">Inventario</h2>

  <div class="d-flex gap-2 mb-3">
    <input id="q" oninput="filtrar()" class="form-control" placeholder="Buscar por nombre, proveedor...">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProducto">
      Agregar producto
    </button>
    <a href="MovimientosInventarioView.php" class="btn btn-outline-primary">📑 Historial de Movimientos</a>
  </div>

  <div class="table-responsive">
    <table id="tabla-inventario" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Producto</th>
          <th>Descripción</th>
          <th>Cant.</th>
          <th>Mín.</th>
          <th>Precio</th>
          <th>Proveedor</th>
          <th>Imagen</th>
          <th>Últ. modif.</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($p = $productos->fetch_assoc()):
        $stockBajo = ((int)$p['cantidad'] <= (int)$p['cantidad_minima']);
      ?>
        <tr class="<?= $stockBajo ? 'table-warning' : '' ?>">
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['nombre']) ?></td>
          <td><?= htmlspecialchars($p['descripcion']) ?></td>
          <td><strong><?= (int)$p['cantidad'] ?></strong></td>
          <td><?= (int)$p['cantidad_minima'] ?></td>
          <td>$<?= number_format((float)$p['precio'],2) ?></td>
          <td><?= htmlspecialchars($p['nombre_proveedor'] ?? '') ?></td>
          <td>
            <?php if(!empty($p['imagen'])): ?>
              <img src="../<?= htmlspecialchars($p['imagen']) ?>" alt="img" style="width:48px;height:48px;object-fit:cover">
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($p['fecha_modificacion']) ?></td>
          <td class="d-flex flex-column gap-1">
            <a class="btn btn-sm btn-warning" href="?editar=<?= $p['id'] ?>">Editar</a>
            <a class="btn btn-sm btn-danger" href="?eliminar=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar producto #<?= $p['id'] ?>?')">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= $editarProducto ? 'Editar producto' : 'Agregar producto' ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <?php if ($editarProducto): ?>
          <input type="hidden" name="id" value="<?= $editarProducto['id'] ?>">
        <?php endif; ?>

        <div class="mb-2">
          <label class="form-label">Nombre</label>
          <input name="nombre" class="form-control" required value="<?= $editarProducto['nombre'] ?? '' ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" class="form-control" rows="2"><?= $editarProducto['descripcion'] ?? '' ?></textarea>
        </div>
        <div class="row g-2">
          <div class="col-6">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" min="0" class="form-control" required value="<?= $editarProducto['cantidad'] ?? 0 ?>">
          </div>
          <div class="col-6">
            <label class="form-label">Cantidad mínima</label>
            <input type="number" name="cantidad_minima" min="0" class="form-control" required value="<?= $editarProducto['cantidad_minima'] ?? 5 ?>">
          </div>
        </div>
        <div class="row g-2 mt-1">
          <div class="col-6">
            <label class="form-label">Precio ($)</label>
            <input type="number" step="0.01" min="0" name="precio" class="form-control" required value="<?= $editarProducto['precio'] ?? 0 ?>">
          </div>
          <div class="col-6">
            <label class="form-label">Proveedor</label>
            <select name="id_proveedor" class="form-select">
              <option value="">— Seleccione —</option>
              <?php while ($pr = $proveedores->fetch_assoc()): ?>
                <option value="<?= $pr['id_proveedor'] ?>" <?= isset($editarProducto['id_proveedor']) && $editarProducto['id_proveedor']==$pr['id_proveedor'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($pr['nombre']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <!-- Motivos -->
        <?php if (empty($editarProducto)): ?>
          <div class="mt-2">
            <label class="form-label">Motivo de entrada</label>
            <select name="motivo_entrada" class="form-select">
              <option value="alta">Alta (nuevo)</option>
              <option value="compra">Compra / Reposición</option>
              <option value="ajuste_inicial">Ajuste inicial</option>
              <option value="correccion">Corrección</option>
            </select>
            
          </div>
        <?php else: ?>
          <div class="mt-2">
            <label class="form-label">Motivo del ajuste</label>
            <select name="motivo_ajuste" class="form-select">
              <option value="ajuste">Ajuste general</option>
              <option value="danos">Daños</option>
              <option value="devolucion">Devolución</option>
              <option value="perdida">Pérdida</option>
              <option value="correccion">Corrección</option>
              <option value="uso_interno">Uso interno</option>
            </select>
            <small class="text-muted">Solo se registra si cambia la cantidad.</small>
          </div>
        <?php endif; ?>

        <!-- Imagen -->
        <div class="mt-3">
          <label class="form-label d-block">Imagen del producto</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="modo_imagen" id="modoSubir" value="subir" onclick="toggleImagenFuente()" checked>
            <label class="form-check-label" for="modoSubir">Subir desde la PC</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="modo_imagen" id="modoGaleria" value="galeria" onclick="toggleImagenFuente()">
            <label class="form-check-label" for="modoGaleria">Elegir de la galería</label>
          </div>

          <div id="bloqueSubir" class="mt-2">
            <input type="file" name="imagen" accept="image/*" class="form-control" onchange="previewFile(this,'prevImg')">
          </div>

          <div id="bloqueGaleria" class="mt-2" style="display:none">
            <select name="imagen_servidor" class="form-select" onchange="previewSelect(this,'prevImg')">
              <option value="">— Seleccione imagen del servidor —</option>
              <?php foreach($galeria as $ruta): ?>
                <option value="<?= htmlspecialchars($ruta) ?>"><?= htmlspecialchars($ruta) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mt-2">
            <img id="prevImg" src="<?= !empty($editarProducto['imagen']) ? '../'.htmlspecialchars($editarProducto['imagen']) : '' ?>" alt="" style="max-width:120px; max-height:120px; object-fit:cover; border:1px solid #ddd;">
            <?php if (!empty($editarProducto['imagen'])): ?>
              <small class="text-muted d-block">Actual: <?= htmlspecialchars($editarProducto['imagen']) ?></small>
            <?php endif; ?>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <?php if ($editarProducto): ?>
          <button name="actualizar" class="btn btn-primary">Guardar cambios</button>
        <?php else: ?>
          <button name="agregar" class="btn btn-success">Agregar</button>
        <?php endif; ?>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </form>
  </div>
</div>

<?php if ($editarProducto): ?>
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalProducto'));
  myModal.show();
</script>
<?php endif; ?>
