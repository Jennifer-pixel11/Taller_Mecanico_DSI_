<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../model/Conexion.php';
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

    // Filtros
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
