<?php
// views/InformeMecanicoView.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Conexion.php';
require_once '../components/navbar.php';
$conn = Conexion::conectar();
date_default_timezone_set('America/El_Salvador');

// Filtros
$desde      = $_GET['desde'] ?? '';
$hasta      = $_GET['hasta'] ?? '';
$vehiculoId = $_GET['vehiculo_id'] ?? '';
$q          = $_GET['q'] ?? '';
$costomin   = $_GET['cmin'] ?? '';
$costomax   = $_GET['cmax'] ?? '';
$export     = $_GET['export'] ?? '';

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

    $d = substr($r['fecha'], 0, 10);
    $dias[$d] = true;
    if (!isset($porDia[$d])) $porDia[$d] = ['n'=>0, 'monto'=>0.0];
    $porDia[$d]['n']++;
    $porDia[$d]['monto'] += $c;

    $m = substr($r['fecha'], 0, 7);
    if (!isset($porMes[$m])) $porMes[$m] = ['n'=>0, 'monto'=>0.0];
    $porMes[$m]['n']++;
    $porMes[$m]['monto'] += $c;
  }
}

// KPIs
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

// Palabras clave
$stop = array_flip([
  'el', 'la', 'los', 'las', 'de', 'del', 'y', 'o', 'u', 'a', 'en', 'por', 'para', 'con', 'sin', 'al', 'lo', 'un', 'una', 'unos', 'unas',
  'se', 'su', 'sus', 'es', 'son', 'fue', 'fueron', 'ser', 'esta', 'este', 'estos', 'estas', 'que', 'como', 'sobre', 'entre', 'más',
  'menos', 'muy', 'ya', 'no', 'si', 'sí', 'ha', 'han', 'he', 'hemos', 'tiene', 'tienen', 'tu', 'tus'
]);

$freq = [];
foreach ($rows as $r) {
  $txt = mb_strtolower($r['descripcion'] ?? '', 'UTF-8');
  $txt = preg_replace('/[^a-z0-9áéíóúñü\s]/iu', ' ', $txt);
  $parts = preg_split('/\s+/', $txt, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($parts as $w) {
    if (isset($stop[$w])) continue;
    if (mb_strlen($w, 'UTF-8') <= 2) continue;
    $freq[$w] = ($freq[$w] ?? 0) + 1;
  }
}
arsort($freq);
$topPalabras = array_slice($freq, 0, 10, true);

?>
