<?php
require_once(__DIR__ . "/Conexion.php");
//$conexion = Conexion::conectar();

if (!function_exists('crearNotificacion')) {
  function crearNotificacion($conexion, $mensaje, $destinatario = 'Sistema') {
    if (!$conexion) return;
    $stmt = $conexion->prepare("INSERT INTO notificaciones (destinatario, mensaje) VALUES (?, ?)");
    if ($stmt) { $stmt->bind_param("ss", $destinatario, $mensaje); $stmt->execute(); }
  }
}


if (!function_exists('normalizar_motivo')) {
  function normalizar_motivo($motivo, $por_defecto) {
    $m = strtolower(trim((string)$motivo));
    $permitidos = [
      'alta','compra','ajuste_inicial','ajuste','danos','devolucion','perdida','correccion','uso_interno','eliminacion','donacion'
    ];
    return in_array($m, $permitidos, true) ? $m : $por_defecto;
  }
}


if (isset($_POST['agregar'])) {
  $nombre          = trim($_POST['nombre'] ?? '');
  $descripcion     = trim($_POST['descripcion'] ?? '');
  $cantidad        = (int)($_POST['cantidad'] ?? 0);
  $cantidad_minima = (int)($_POST['cantidad_minima'] ?? 5);
  $precio          = (float)($_POST['precio'] ?? 0);
  $id_proveedor    = !empty($_POST['id_proveedor']) ? (int)$_POST['id_proveedor'] : null;

  
  $ruta_final = null;

  
  $img_srv = trim($_POST['imagen_servidor'] ?? '');
  if ($img_srv !== '') {
    if (preg_match('#^(inventario|uploads)/[A-Za-z0-9._/\-]+$#', $img_srv)) {
      $ruta_final = $img_srv;
    }
  }


  if (!$ruta_final && !empty($_FILES['imagen']['name'])) {
    $nombre_img = basename($_FILES['imagen']['name']);
    $ruta_temp  = $_FILES['imagen']['tmp_name'];
    $ruta_final = 'uploads/' . $nombre_img;
    if (!is_dir('../uploads')) { @mkdir('../uploads', 0777, true); }
    move_uploaded_file($ruta_temp, '../' . $ruta_final);
  }


  $stmt = $conexion->prepare("INSERT INTO inventario (nombre, descripcion, cantidad, cantidad_minima, precio, imagen, id_proveedor) VALUES (?,?,?,?,?,?,?)");
  $stmt->bind_param("ssiidss", $nombre, $descripcion, $cantidad, $cantidad_minima, $precio, $ruta_final, $id_proveedor);
  $stmt->execute();

 
  $motivo_entrada = normalizar_motivo($_POST['motivo_entrada'] ?? 'alta', 'alta');


  if (function_exists('crearNotificacion')) {
    $idNuevo = $conexion->insert_id;
    crearNotificacion($conexion, "MOV|tipo=entrada|motivo={$motivo_entrada}|producto={$nombre}|id={$idNuevo}|cant={$cantidad}");
    if ($cantidad <= $cantidad_minima) {
      crearNotificacion($conexion, "ALERTA|stock_bajo|producto={$nombre}|id={$idNuevo}|cant={$cantidad}|min={$cantidad_minima}");
    }
  }

  header("Location: InventarioView.php");
  exit;
}


if (isset($_POST['actualizar'])) {
  $id              = (int)($_POST['id'] ?? 0);
  $nombre          = trim($_POST['nombre'] ?? '');
  $descripcion     = trim($_POST['descripcion'] ?? '');
  $cantidad        = (int)($_POST['cantidad'] ?? 0);
  $cantidad_minima = (int)($_POST['cantidad_minima'] ?? 5);
  $precio          = (float)($_POST['precio'] ?? 0);
  $id_proveedor    = !empty($_POST['id_proveedor']) ? (int)$_POST['id_proveedor'] : null;

 
  $cantAnterior = 0; $imgAnterior = null;
  $resAnt = $conexion->query("SELECT cantidad, imagen FROM inventario WHERE id={$id}");
  if ($ra = $resAnt->fetch_assoc()) { $cantAnterior = (int)$ra['cantidad']; $imgAnterior = $ra['imagen']; }

  
  $ruta_final = $imgAnterior;

  
  $img_srv = trim($_POST['imagen_servidor'] ?? '');
  if ($img_srv !== '') {
    if (preg_match('#^(inventario|uploads)/[A-Za-z0-9._/\-]+$#', $img_srv)) {
      $ruta_final = $img_srv;
    }
  }
 
  if (!empty($_FILES['imagen']['name'])) {
    $nombre_img = basename($_FILES['imagen']['name']);
    $ruta_temp  = $_FILES['imagen']['tmp_name'];
    $ruta_final = 'uploads/' . $nombre_img;
    if (!is_dir('../uploads')) { @mkdir('../uploads', 0777, true); }
    move_uploaded_file($ruta_temp, '../' . $ruta_final);
  }

  
  $stmt = $conexion->prepare("UPDATE inventario SET nombre=?, descripcion=?, cantidad=?, cantidad_minima=?, precio=?, imagen=?, id_proveedor=? WHERE id=?");
  $stmt->bind_param("ssiidssi", $nombre, $descripcion, $cantidad, $cantidad_minima, $precio, $ruta_final, $id_proveedor, $id);
  $stmt->execute();

 
  $motivo_ajuste = normalizar_motivo($_POST['motivo_ajuste'] ?? 'ajuste', 'ajuste');

  if (function_exists('crearNotificacion')) {
    $delta = $cantidad - $cantAnterior;
    if ($delta !== 0) {
      $tipo = $delta > 0 ? 'entrada' : 'salida';
      crearNotificacion($conexion, "MOV|tipo={$tipo}|motivo={$motivo_ajuste}|producto={$nombre}|id={$id}|cant=" . abs($delta));
    }
    if ($cantidad <= $cantidad_minima) {
      crearNotificacion($conexion, "ALERTA|stock_bajo|producto={$nombre}|id={$id}|cant={$cantidad}|min={$cantidad_minima}");
    }
  }

  header("Location: InventarioView.php");
  exit;
}


if (isset($_GET['eliminar'])) {
  $id = (int)$_GET['eliminar'];

  
  $motivo_del = normalizar_motivo($_GET['motivo'] ?? 'eliminacion', 'eliminacion');

  $reg = $conexion->query("SELECT id, nombre, cantidad FROM inventario WHERE id={$id}")->fetch_assoc();
  $conexion->query("DELETE FROM inventario WHERE id={$id}");

  if ($reg && function_exists('crearNotificacion')) {
    crearNotificacion($conexion, "MOV|tipo=salida|motivo={$motivo_del}|producto={$reg['nombre']}|id={$reg['id']}|cant={$reg['cantidad']}");
  }
  header("Location: InventarioView.php");
  exit;
}


$editarProducto = null;
if (isset($_GET['editar'])) {
  $id = (int)$_GET['editar'];
  $resultado = $conexion->query("SELECT * FROM inventario WHERE id={$id}");
  $editarProducto = $resultado->fetch_assoc();
}

$productos = $conexion->query("
  SELECT i.*, p.nombre AS nombre_proveedor
  FROM inventario i
  LEFT JOIN proveedor_insumos p ON i.id_proveedor = p.id_proveedor
  ORDER BY i.id DESC
");

$proveedores = $conexion->query("SELECT id_proveedor, nombre FROM proveedor_insumos ORDER BY nombre ASC");


date_default_timezone_set('America/El_Salvador');

// Función para listar imágenes del directorio
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
    listar_imagenes_dir('inventario'),
    listar_imagenes_dir('uploads')
);


?>