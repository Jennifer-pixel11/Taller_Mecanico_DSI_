<head>
    <title>Dashboard</title>
    <!-- Incluir Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>

<div class="container mt-4">
    <div class="card bg-success p-2 text-dark bg-opacity-10 border-0 rounded-4 w-100">
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