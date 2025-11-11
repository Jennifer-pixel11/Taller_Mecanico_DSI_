
<head>
    <title>Dashboard</title>
    <!-- Incluir Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>

<div class="container mt-4">
    <div class="card bg-white p-2 text-dark bg-opacity-15 border-0 rounded-4 w-100">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
            
            <!-- Información del Usuario -->
            <div class="mb-3 mb-md-0">
                <h4 class="tittle">👋 Bienvenido/a, <?php echo htmlspecialchars($usuario); ?>!</h4>
                <h6 class="mb-1"><strong>Fecha y hora actual:</strong> <?php echo $fechaHoraActual; ?></h6>
                <h6 class="mb-0">¡Nos alegra tenerte de vuelta en el sistema de gestión del taller! 🎉</h6>
            </div>
        </div>
    </div>
</div>
  
    <!-- Dashboard -->
<div class="container mt-4">
    <div class="row">
        <!-- Gráfico de Ingresos -->
        <div class="col-lg-6 col-12 mb-3">  <!-- Aseguramos que ocupen 12 columnas en pantallas pequeñas y 6 en pantallas grandes -->
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Gráfico de Ingresos</h5>
                    <!-- Gráfico de Ingresos -->
                    <canvas id="clientesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Inventario por Proveedor -->
        <div class="col-lg-6 col-12 mb-3">  <!-- Agregamos mb-3 para que haya espacio entre los gráficos cuando se apilen -->
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Inventario por Proveedor</h5>
                    <canvas id="inventarioChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Gráfico de Clientes
new Chart(document.getElementById("clientesChart"), {
    type: 'bar',
    data: {
        labels: ['Clientes', 'Vehículos','Servicios'],
        datasets: [{
            label: 'Clientes', // Etiqueta de la primera barra
            data: [<?php echo $estadisticas['totalClientes']; ?>, 0, 0], // Asignamos el total de clientes a la primera barra
            backgroundColor: '#36a2eb', // Color de la barra
            borderColor: '#1e88e5', // Color del borde de la barra
            borderWidth: 1
        }, {
            label: 'Vehículos', // Etiqueta de la segunda barra
            data: [0, <?php echo $estadisticas['totalVehiculos']; ?>, 0], // Asignamos el total de vehículos a la segunda barra
            backgroundColor: '#ffb74d', // Color de la barra
            borderColor: '#ff9800', // Color del borde de la barra
            borderWidth: 1    
        }, {
            label: 'Servicios', // Etiqueta de la primera barra
            data: [0,0,<?php echo $estadisticas['totalServicios']; ?>], // Asignamos el total de clientes a la primera barra
            backgroundColor: '#0a7e71ff', // Color de la barra
            borderColor: '#09778aff', // Color del borde de la barra
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true // Para que el eje Y comience desde 0
            }
        }
    }
});
</script>
<!-- Gráfico de Inventario por Proveedor -->
<script>
    new Chart(document.getElementById("inventarioChart"), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($estadisticasInventario, 'proveedor')); ?>, // Proveedores
            datasets: [{
                label: 'Inventario',
                data: <?php echo json_encode(array_column($estadisticasInventario, 'totalInventario')); ?>, // Totales de inventario
                backgroundColor: '#ffcc00', // Color de las barras
                borderColor: '#ffcc00',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<div class="container py-4">
  <h3 class="mb-3">Productos con stock bajo</h3>

  <div class="row g-3" id="bajo-stock-cards">
    <?php if ($productosBajoStock && $productosBajoStock->num_rows > 0): ?>
        <?php while ($p = $productosBajoStock->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card border-warning producto-stock">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['nombre']) ?></h5>
                        <p class="card-text">
                            Cantidad: <strong><?= (int)$p['cantidad'] ?></strong><br>
                            Mínimo: <?= (int)$p['cantidad_minima'] ?><br>
                            Proveedor: <?= htmlspecialchars($p['nombre_proveedor'] ?? '') ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-muted">No hay productos con stock bajo.</p>
    <?php endif; ?>
  </div>
</div>

<div class="container py-4">
  <h3 class="mb-3">🧍 Últimos clientes registrados</h3>

  <div class="row g-3">
    <?php if ($ultimosClientes && $ultimosClientes->num_rows > 0): ?>
      <?php while ($c = $ultimosClientes->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="card border-primary shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($c['nombre']) ?></h5>
              <p class="card-text">
                <strong>Teléfono:</strong> <?= htmlspecialchars($c['telefono']) ?><br>
                <strong>Correo:</strong> <?= htmlspecialchars($c['correo']) ?><br>
                <strong>Dirección:</strong> <?= htmlspecialchars($c['direccion']) ?>
              </p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">No hay clientes recientes.</p>
    <?php endif; ?>
  </div>
</div>


<!-- 🔹 Estilos de animación -->
<style>
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
}
.shake {
  animation: shake 0.5s ease-in-out;
}
</style>

<!-- 🔹 Script para reproducir sonido y animar -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const productos = document.querySelectorAll(".producto-stock");

  if (productos.length > 0) {
    // Reproduce un sonido cuando haya productos con bajo stock
    const alertSound = new Audio("alerta.mp3"); // coloca el archivo alerta.mp3 en tu carpeta raíz o assets/
    alertSound.play();

    // Aplica la animación shake a cada card
    productos.forEach(card => {
      card.classList.add("shake");
      setTimeout(() => card.classList.remove("shake"), 1000);
    });
  }
});
</script>






