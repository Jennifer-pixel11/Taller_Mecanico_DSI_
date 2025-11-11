<?php
// Iniciar la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once './model/DashboardModel.php';
require_once("./model/Cliente.php");
$clienteModel = new Cliente();
$ultimosClientes = $clienteModel->obtenerUltimosClientes(2);

// Crear instancia del modelo
$dashboardModel = new DashboardModel();
// En DashboardController.php
//session_start();
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado'; // Asegúrate de que el nombre de usuario esté en la sesión
$fechaHoraActual = date('d-m-Y H:i:s'); // Fecha y hora actual

// Obtener estadísticas del dashboard
$estadisticas = $dashboardModel->obtenerEstadisticas();
   // Obtener estadísticas de inventario (por proveedor)
$estadisticasInventario = $dashboardModel->obtenerEstadisticasInventario();

// Incluir la vista del dashboard

include_once("model/Inventario.php");
$inventarioModel = new Inventario();

$productosBajoStock = $inventarioModel->obtenerBajoStock();
require_once './model/Cita.php';

$citaModel = new Cita();
$citasPendientes = $citaModel->obtenerPendientes(3); // solo mostrar 3 por ejemplo

include("components/dashboard.php");

?>
