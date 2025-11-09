<?php
require_once '../controller/ServicioReporteController.php';
?>
<head>
  <title>Información General de Servicios</title>
  <link rel="stylesheet" type="text/css" href="/Taller_Mecanico_DSI_/static/css/servicioReporte.css">
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

<script src="../static/js/servicioReporte.js"></script>