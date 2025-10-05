<?php
// views/InformeMecanicoView.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Conexion.php';
require_once '../components/navbar.php';
$conn = Conexion::conectar();
date_default_timezone_set('America/El_Salvador');

/* ========= Filtros ========= */
$desde      = $_GET['desde']       ?? '';
$hasta      = $_GET['hasta']       ?? '';
$vehiculoId = $_GET['vehiculo_id'] ?? '';
$q          = $_GET['q']           ?? '';
$costomin   = $_GET['cmin']        ?? '';
$costomax   = $_GET['cmax']        ?? '';
$export     = $_GET['export']      ?? '';

$where = [];
if ($desde)             $where[] = "fecha >= '".$conn->real_escape_string($desde)."'";
if ($hasta)             $where[] = "fecha <= '".$conn->real_escape_string($hasta)."'";
if ($vehiculoId !== '') $where[] = "vehiculo_id = ".(int)$vehiculoId;
if ($q)                 $where[] = "descripcion LIKE '%".$conn->real_escape_string($q)."%'";

/* Nota: filtro de costo se aplica en PHP para no tocar tu SQL original */
$sql = "SELECT id, vehiculo_id, descripcion, fecha, costo FROM servicios";
if ($where) $sql .= " WHERE ".implode(" AND ", $where);
$sql .= " ORDER BY fecha DESC";
$res = $conn->query($sql);

/* ========= Recolectar filas, aplicar costo min/max y calcular métricas ========= */
$rows = [];
$total = 0;
$sum = 0.0;
$costos = [];
$dias = [];      // set de días activos (yyyy-mm-dd)
$porDia = [];    // yyyy-mm-dd => ['n'=>#, 'monto'=>sum]
$porMes = [];    // yyyy-mm   => ['n'=>#, 'monto'=>sum]

if ($res) {
  while ($r = $res->fetch_assoc()) {
    $c = (float)$r['costo'];
    if ($costomin !== '' && $c < (float)$costomin) continue;
    if ($costomax !== '' && $c > (float)$costomax) continue;

    $rows[] = $r;
    $total++;
    $sum += $c;
    $costos[] = $c;

    $d = substr($r['fecha'], 0, 10); // yyyy-mm-dd
    $dias[$d] = true;
    if (!isset($porDia[$d])) $porDia[$d] = ['n'=>0, 'monto'=>0.0];
    $porDia[$d]['n']++;
    $porDia[$d]['monto'] += $c;

    $m = substr($r['fecha'], 0, 7);  // yyyy-mm
    if (!isset($porMes[$m])) $porMes[$m] = ['n'=>0, 'monto'=>0.0];
    $porMes[$m]['n']++;
    $porMes[$m]['monto'] += $c;
  }
}

/* KPIs */
function money($n){ return '$'.number_format((float)$n,2); }
$prom = $total ? $sum/$total : 0.0;
sort($costos);
$min = $costos ? $costos[0] : 0.0;
$max = $costos ? $costos[count($costos)-1] : 0.0;
$mediana = 0.0;
if ($costos) {
  $mid = intdiv(count($costos), 2);
  $mediana = (count($costos) % 2 === 0) ? (($costos[$mid-1]+$costos[$mid])/2) : $costos[$mid];
}
$numDiasActivos = count($dias);
$serviciosPorDia = $numDiasActivos ? ($total / $numDiasActivos) : 0.0;

/* ========= Top palabras clave (muy simple, español) ========= */
$stop = array_flip([
  'el','la','los','las','de','del','y','o','u','a','en','por','para','con','sin','al','lo','un','una','unos','unas',
  'se','su','sus','es','son','fue','fueron','ser','esta','este','estos','estas','que','como','sobre','entre','más',
  'menos','muy','ya','no','si','sí','ha','han','he','hemos','tiene','tienen','tu','tus'
]);
$freq = [];
foreach ($rows as $r) {
  $txt = mb_strtolower($r['descripcion'] ?? '', 'UTF-8');
  // reemplazar todo lo que no sea letra/numero por espacios
  $txt = preg_replace('/[^a-z0-9áéíóúñü\s]/iu', ' ', $txt);
  $parts = preg_split('/\s+/', $txt, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($parts as $w) {
    if (isset($stop[$w])) continue;
    if (mb_strlen($w,'UTF-8') <= 2) continue;
    $freq[$w] = ($freq[$w] ?? 0) + 1;
  }
}
arsort($freq);
$topPalabras = array_slice($freq, 0, 10, true);


?>
<head>
  <meta charset="utf-8">
  <title>Información General de Servicios</title>
  <link rel="stylesheet" href="../public/styles.css">
  <style>
    .kpi { border:1px solid #e5e5e5; border-radius:12px; padding:12px; text-align:center; }
    .kpi h3 { margin:4px 0; font-size:1.15rem; }
    .kpi small { color:#666; }
    @media print {
      .no-print { display:none !important; }
      .kpi { page-break-inside: avoid; }
      table { page-break-inside: auto; }
      tr { page-break-inside: avoid; page-break-after: auto; }
    }
  </style>
  <script>
    function imprimir(){ window.print(); }
    function limpiarFiltros(){ window.location.href='?'; }
  </script>
</head>

<div class="container py-4">
 <h2 class="text-center mb-3">Información General de Servicios</h2>

  <!-- Filtros (no modifican BD) -->
  <form class="row g-2 mb-3 no-print" method="get">
    <div class="col-12 col-md-3 align-self-end d-flex gap-2">
      <button type="button" class="btn btn-dark w-100" onclick="imprimir()">Imprimir</button>
    </div>
  </form>

  
  <div class="row g-2 mb-3">
    <div class="col-6 col-lg-3"><div class="kpi"><small>Total servicios</small><h3><?= $total ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Costo total</small><h3><?= money($sum) ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Promedio por servicio</small><h3><?= money($prom) ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Mediana</small><h3><?= money($mediana) ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Mínimo</small><h3><?= money($min) ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Máximo</small><h3><?= money($max) ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Días activos</small><h3><?= $numDiasActivos ?></h3></div></div>
    <div class="col-6 col-lg-3"><div class="kpi"><small>Servicios por día</small><h3><?= number_format($serviciosPorDia,2) ?></h3></div></div>
  </div>

  <!-- Tabla Detalle -->
  <div class="table-responsive mb-4">
    <table class="table table-striped align-middle">
      <thead>
        <tr><th>ID</th><th>Vehículo</th><th>Descripción</th><th>Fecha</th><th>Costo</th></tr>
      </thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="5" class="text-center text-muted">No hay registros para los filtros seleccionados.</td></tr>
        <?php else: foreach ($rows as $s): ?>
          <tr>
            <td><?= $s['id'] ?></td>
            <td><?= $s['vehiculo_id'] ?></td>
            <td><?= htmlspecialchars($s['descripcion']) ?></td>
            <td><?= htmlspecialchars($s['fecha']) ?></td>
            <td><?= money($s['costo']) ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Resumen por día -->
  <h4 class="mt-4">Resumen por día</h4>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Día</th><th># Servicios</th><th>Costo total</th></tr></thead>
      <tbody>
        <?php
        if ($porDia) {
          ksort($porDia);
          foreach ($porDia as $dia => $agg) {
            echo "<tr><td>".htmlspecialchars($dia)."</td><td>{$agg['n']}</td><td>".money($agg['monto'])."</td></tr>";
          }
        } else {
          echo '<tr><td colspan="3" class="text-center text-muted">Sin datos para resumir.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Resumen por mes -->
  <h4 class="mt-4">Resumen por mes</h4>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Mes</th><th># Servicios</th><th>Costo total</th></tr></thead>
      <tbody>
        <?php
        if ($porMes) {
          ksort($porMes);
          foreach ($porMes as $mes => $agg) {
            echo "<tr><td>".htmlspecialchars($mes)."</td><td>{$agg['n']}</td><td>".money($agg['monto'])."</td></tr>";
          }
        } else {
          echo '<tr><td colspan="3" class="text-center text-muted">Sin datos para resumir.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Descripciones -->
  <h4 class="mt-4">Tópicos más frecuentes (descripción)</h4>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Palabra</th><th>Frecuencia</th></tr></thead>
      <tbody>
        <?php
        if ($topPalabras) {
          foreach ($topPalabras as $pal => $n) {
            echo "<tr><td>".htmlspecialchars($pal)."</td><td>{$n}</td></tr>";
          }
        } else {
          echo '<tr><td colspan="2" class="text-center text-muted">No hay suficientes datos.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>