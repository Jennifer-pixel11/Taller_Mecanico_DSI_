<?php 
require_once '../components/navbar.php'; 
include '../controller/MovimientosInventarioController.php';
?>

<head>
  <title>Historial de Movimientos</title>
 
  <?php if ($isPrint): ?>
  <script>
    
    window.addEventListener('load', () => window.print());
  </script>
  <?php endif; ?>
</head>

<div class="container py-4">
  <h2 class="mb-3">Historial de Movimientos</h2>

  <?php if ($isPrint): ?>
    <div class="header-print">
      <h3>Reporte de Movimientos de Inventario</h3>
      <div class="muted">
        Fecha de generación: <?= date('Y-m-d H:i') ?><br>
        Filtros:
        <?= $desde ? "Desde ".h($desde) : "—" ?>
        <?= $hasta ? " / Hasta ".h($hasta) : "" ?>
        <?= $tipo ? " / Tipo: ".h($tipo) : "" ?>
        <?= $motivo ? " / Motivo: ".h(texto_motivo($motivo)) : "" ?>
        <?= $q ? " / Búsqueda: ".h($q) : "" ?>
      </div>
      <hr>
    </div>
  <?php endif; ?>

  <!-- Filtros -->
  <form class="row g-2 mb-3 no-print" method="get">
    <div class="col-6 col-md-2">
      <label class="form-label">Desde</label>
      <input type="date" name="desde" value="<?= h($desde) ?>" class="form-control">
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label">Hasta</label>
      <input type="date" name="hasta" value="<?= h($hasta) ?>" class="form-control">
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label">Tipo</label>
      <select name="tipo" class="form-select">
        <option value="">Todos</option>
        <option value="entrada" <?= $tipo==='entrada'?'selected':'' ?>>Entrada</option>
        <option value="salida"  <?= $tipo==='salida'?'selected':'' ?>>Salida</option>
        <option value="ajuste"  <?= $tipo==='ajuste'?'selected':'' ?>>Ajuste</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <label class="form-label">Motivo</label>
      <select name="motivo" class="form-select">
        <option value="">Todos</option>
        <?php
        $motivos = ['alta','compra','ajuste_inicial','ajuste','correccion','danos','devolucion','perdida','uso_interno','donacion','eliminacion'];
        foreach ($motivos as $m) {
          $sel = ($motivo===$m)?'selected':'';
          echo "<option value='".h($m)."' {$sel}>".h(texto_motivo($m))."</option>";
        }
        ?>
      </select>
    </div>
    <div class="col-12 col-md-3">
      <label class="form-label">Buscar</label>
      <input type="text" name="q" value="<?= h($q) ?>" class="form-control" placeholder="Producto, ID, motivo, detalle...">
    </div>

    <div class="col-12 d-flex gap-2 mt-2">
      <button class="btn btn-primary">Filtrar</button>
      <a class="btn btn-outline-secondary" href="?">Limpiar</a>

      <a class="btn btn-danger"
         href="?<?= http_build_query(array_merge($_GET, ['print' => '1'])) ?>"
         target="_blank">
        Exportar PDF
      </a>
    </div>
  </form>

  <!-- Tabla -->
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Tipo</th>
          <th>Motivo</th>
          <th>Producto</th>
          <th>ID</th>
          <th>Cantidad</th>
          <th class="no-print">Detalle</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="7" class="text-center muted">Sin movimientos con esos filtros.</td></tr>
        <?php else: foreach ($rows as $r):
          $tipoTag = strtolower($r['tipo'] ?? '');
          $claseTipo = in_array($tipoTag, ['entrada','salida','ajuste']) ? $tipoTag : '';
          $mot = strtolower($r['motivo'] ?? '');
          $critico = in_array($mot, ['perdida','danos']) ? 'critico' : '';
        ?>
          <tr>
            <td><?= h($r['fecha'] ?? '') ?></td>
            <td><span class="tag <?= h($claseTipo) ?>"><?= h(ucfirst($r['tipo'] ?? '')) ?></span></td>
            <td class="<?= $critico ?>"><?= h(texto_motivo($r['motivo'] ?? '')) ?></td>
            <td><?= h($r['producto'] ?? '') ?></td>
            <td><?= h($r['id'] ?? '') ?></td>
            <td><?= h($r['cant'] ?? '') ?></td>
            <td class="no-print"><?= h($r['detalle'] ?? '') ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
