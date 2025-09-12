<?php
require_once '../model/Comprobante.php';

$comprobanteModel = new Comprobante();
$comprobante = null;

if (isset($_GET['id'])) {
    $comprobante = $comprobanteModel->obtenerPorId($_GET['id']);
}
?>
<head>
  <title>Comprobante</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
    }
    .comprobante {
      max-width: 700px;
      margin: auto;
      background: #fff;
      border: 1px solid #ddd;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .header img {
      max-height: 80px;
    }
    .header .taller-info {
      text-align: right;
    }
    .section {
      margin-bottom: 15px;
    }
    .section h3 {
      margin-bottom: 5px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 3px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    table, th, td {
      border: 1px solid #000;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    .total {
      text-align: right;
      font-size: 18px;
      font-weight: bold;
    }
    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 12px;
      color: #555;
    }
  </style>
</head>
<body>
<div class="comprobante">
  <div class="header">
    <!-- Logo -->
    <img src="../public/logotipo.png" alt="Logo Taller">
    <!-- Datos del Taller -->
    <div class="taller-info">
      <h2>MECANICA EXPERT</h2>
      <p>Av. Efrain Villatoro, Osicala #123</p>
      <p>Tel: 2654-1234</p>
      <p>Mecanicaexpertsv_2025@gmail.com</p>
    </div>
  </div>

  <?php if ($comprobante): ?>
    <!-- Datos comprobante -->
    <div class="section">
      <h3>Comprobante</h3>
      <p><strong>Número:</strong> <?= $comprobante['numero'] ?></p>
      <p><strong>Fecha emisión:</strong> <?= $comprobante['fecha_emision'] ?></p>
    </div>

    <!-- Datos cliente -->
    <div class="section">
      <h3>Cliente</h3>
      <p><strong>Nombre:</strong> <?= $comprobante['cliente'] ?></p>
      <p><strong>Teléfono:</strong> <?= $comprobante['telefono'] ?? 'N/A' ?></p>
      <p><strong>Correo:</strong> <?= $comprobante['correo'] ?? 'N/A' ?></p>
    </div>

    <!-- Datos vehículo -->
    <div class="section">
      <h3>Vehículo</h3>
      <p><strong>Placa:</strong> <?= $comprobante['placa'] ?></p>
      <p><strong>Marca:</strong> <?= $comprobante['marca'] ?></p>
      <p><strong>Modelo:</strong> <?= $comprobante['modelo'] ?></p>
    </div>

    <!-- Detalle servicio -->
    <div class="section">
      <h3>Detalle del servicio</h3>
      <table>
        <tr>
          <th>Descripción</th>
          <th>Fecha</th>
          <th>Total</th>
        </tr>
        <tr>
          <td><?= $comprobante['descripcion'] ?></td>
          <td><?= $comprobante['fecha'] ?></td>
          <td>$<?= number_format($comprobante['total'], 2) ?></td>
        </tr>
      </table>
    </div>

    <!-- Total -->
    <p class="total">Total a pagar: $<?= number_format($comprobante['total'], 2) ?></p>

    <!-- Botón imprimir -->
    <div style="text-align: center; margin-top:20px;">
      <button onclick="window.print()">🖨 Imprimir</button>
    </div>
  <?php else: ?>
    <p>No se encontró el comprobante.</p>
  <?php endif; ?>

  <!-- Footer -->
  <div class="footer">
    <p>¡Gracias por su preferencia!</p>
    <p>Este comprobante no sustituye factura de crédito fiscal. Garantía de 30 días sobre mano de obra.</p>
  </div>
</div>
</body>
