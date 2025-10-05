<?php
require_once("../model/Comprobante.php");

$comprobanteModel = new Comprobante();


if (isset($_GET['generar'])) {
    $servicio_id = intval($_GET['generar']);
    $total = floatval($_GET['total']);

    $id_comprobante = $comprobanteModel->generar($servicio_id, $total);

    header("Location: ../views/ComprobanteView.php?id=$id_comprobante");
    exit;
}

if (isset($_GET['generar']) && isset($_GET['total'])) {
    $idServicio = (int)$_GET['generar'];
    $total = number_format((float)$_GET['total'], 2);

    $conn = Conexion::conectar();
    $res = $conn->query("SELECT s.id, s.descripcion, s.fecha, s.costo,
                                v.placa, v.marca, v.modelo, c.nombre AS cliente
                         FROM servicios s
                         INNER JOIN vehiculos v ON s.vehiculo_id = v.id
                         INNER JOIN clientes c ON v.cliente = c.id
                         WHERE s.id = $idServicio");
    $serv = $res->fetch_assoc();

    if ($serv) {
        // Plantilla simple HTML (se imprime como comprobante)
        echo "<h2>Comprobante de Servicio #{$serv['id']}</h2>";
        echo "<p><strong>Cliente:</strong> {$serv['cliente']}</p>";
        echo "<p><strong>Vehículo:</strong> {$serv['placa']} - {$serv['marca']} {$serv['modelo']}</p>";
        echo "<p><strong>Servicio:</strong> {$serv['descripcion']}</p>";
        echo "<p><strong>Fecha:</strong> {$serv['fecha']}</p>";
        echo "<p><strong>Total:</strong> $$total</p>";
        echo "<hr><button onclick='window.print()'>Imprimir</button>";
    } else {
        echo "Servicio no encontrado.";
    }
} else {
    echo "Datos insuficientes.";
}