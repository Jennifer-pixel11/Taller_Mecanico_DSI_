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

