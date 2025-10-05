<?php
// views/MovimientosInventarioView.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Conexion.php';
require_once '../components/navbar.php';
$conn = Conexion::conectar();
date_default_timezone_set('America/El_Salvador');

function texto_motivo($motivo) {
  $map = [
    'alta'           => 'Alta de producto',
    'compra'         => 'Compra / Reposición',
    'ajuste_inicial' => 'Ajuste inicial',
    'ajuste'         => 'Ajuste manual',
    'correccion'     => 'Corrección de inventario',
    'danos'          => 'Ajuste por daños',
    'devolucion'     => 'Ajuste por devolución',
    'perdida'        => 'Ajuste por pérdida',
    'uso_interno'    => 'Consumo interno',
    'donacion'       => 'Ingreso por donación',
    'eliminacion'    => 'Eliminación del catálogo',
  ];
  $m = strtolower($motivo ?? '');
  return $map[$m] ?? ucfirst($m);
}

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }


$desde  = $_GET['desde']  ?? '';
$hasta  = $_GET['hasta']  ?? '';
$tipo   = $_GET['tipo']   ?? '';   // entrada|salida|ajuste
$motivo = $_GET['motivo'] ?? '';   // ver mapa
$q      = $_GET['q']      ?? '';   // texto libre
$export = $_GET['export'] ?? '';
$isPrint = isset($_GET['print']) && $_GET['print'] === '1';


$sql = "SELECT id, mensaje, fecha_envio FROM notificaciones WHERE mensaje LIKE 'MOV|%'";
$conds = [];
if ($desde) $conds[] = "fecha_envio >= '".$conn->real_escape_string($desde)." 00:00:00'";
if ($hasta) $conds[] = "fecha_envio <= '".$conn->real_escape_string($hasta)." 23:59:59'";
if ($conds) $sql .= " AND ".implode(" AND ", $conds);
$sql .= " ORDER BY fecha_envio DESC";

$res = $conn->query($sql);


$rows = [];
if ($res) {
  while ($n = $res->fetch_assoc()) {
    $msg   = (string)$n['mensaje'];
    $parts = explode('|', $msg);
    if (count($parts) < 2 || trim($parts[0]) !== 'MOV') continue;

    $data = [
      'fecha' => $n['fecha_envio'],
      'tipo' => '',
      'motivo' => '',
      'producto' => '',
      'id' => '',
      'cant' => '',
      'detalle' => '',
    ];

    foreach ($parts as $i => $p) {
      if ($i === 0) continue;
      $kv = explode('=', $p, 2);
      if (count($kv) === 2) {
        $k = strtolower(trim($kv[0]));
        $v = trim($kv[1]);
        if (isset($data[$k])) $data[$k] = $v;
      }
    }

  
    if ($tipo && strtolower($data['tipo']) !== strtolower($tipo)) continue;
    if ($motivo && strtolower($data['motivo']) !== strtolower($motivo)) continue;

    if ($q) {
      $needle = mb_strtolower($q, 'UTF-8');
      $hay = false;
      foreach (['producto','id','motivo','detalle'] as $k) {
        if (isset($data[$k]) && stripos((string)$data[$k], $q) !== false) { $hay = true; break; }
      }
      if (!$hay) continue;
    }

    $rows[] = $data;
  }
}



?>
<head>
  <meta charset="utf-8">
  <title>Historial de Movimientos</title>
  <link rel="stylesheet" href="../public/styles.css">
  <style>
    .tag{padding:.2rem .45rem;border-radius:.45rem;font-size:.85rem}
    .entrada{background:#e8f7ee;color:#176b3a}
    .salida{background:#fdeaea;color:#b42318}
    .ajuste{background:#eef1f8;color:#1f3a66}
    .critico{color:#b42318;font-weight:600}
    .muted{color:#666}
   
    @media print {
      .no-print { display: none !important; }
      .table { border-collapse: collapse; width: 100%; }
      .table th, .table td { border: 1px solid #ccc; padding: 6px; }
      .header-print { margin-bottom: 12px; }
    }
  </style>
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
