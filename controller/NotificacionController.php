<?php
require_once(__DIR__ . "/../model/Conexion.php");
$conexion = Conexion::conectar();
if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

header('Content-Type: application/json; charset=utf-8');

if ($action === 'unread_count') {
    $res = $conexion->query("SELECT COUNT(*) AS c FROM notificaciones WHERE leido = 0 AND tipo = 'stock_bajo'");
    $c = 0;
    if ($res) { $r = $res->fetch_assoc(); $c = (int)$r['c']; }
    echo json_encode(['count' => $c]);
    exit;
}

if ($action === 'unread_list') {
    $out = [];
    $res = $conexion->query("SELECT id, mensaje, producto_id, datos_json, fecha_envio FROM notificaciones WHERE leido = 0 AND tipo = 'stock_bajo' ORDER BY fecha_envio DESC LIMIT 25");
    if ($res) {
        while ($r = $res->fetch_assoc()) { $out[] = $r; }
    }
    echo json_encode($out);
    exit;
}

if ($action === 'mark_read' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id > 0) {
        $stmt = $conexion->prepare("UPDATE notificaciones SET leido = 1 WHERE id = ?");
        if ($stmt) { $stmt->bind_param('i', $id); $stmt->execute(); }
        echo json_encode(['ok' => true]);
        exit;
    }
    echo json_encode(['ok' => false, 'error' => 'id inválido']);
    exit;
}

// Fallback: no action
echo json_encode(['error' => 'no action']);
exit;
?>
