<?php
require_once 'Conexion.php';
class DashboardModel {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }
     // Función para obtener estadísticas del dashboard (solo total de clientes)
    public function obtenerEstadisticas() {
        $sql = "SELECT COUNT(*) AS totalClientes FROM clientes"; // Asegúrate de que la tabla 'clientes' existe
        $result = $this->conn->query($sql);
        $rowClientes = $result->fetch_assoc();
        
          // Consulta para obtener el total de vehículos
    $sqlVehiculos = "SELECT COUNT(*) AS totalVehiculos FROM vehiculos";
    $resultVehiculos = $this->conn->query($sqlVehiculos);
    $rowVehiculos = $resultVehiculos->fetch_assoc();
    
     // Consulta para obtener el total de servicios completados
    $sqlServicios = "SELECT COUNT(*) AS totalServicios FROM servicios"; // Filtra por los servicios completados
    $resultServicios = $this->conn->query($sqlServicios);
    $rowServicios = $resultServicios->fetch_assoc();

         // Retornar un array con todas las estadísticas
    return [
        'totalClientes' => $rowClientes['totalClientes'],  // Total de clientes
        'totalVehiculos' => $rowVehiculos['totalVehiculos'], // Total de vehículos
        'totalServicios' => $rowServicios['totalServicios']   // Total de servicios completados
    ];
    }
    public function obtenerEstadisticasInventario() {
    
    // Consulta SQL para obtener el total de inventario por proveedor
    $sql = "SELECT p.nombre AS proveedor, COUNT(i.cantidad) AS totalInventario
            FROM inventario i
            INNER JOIN proveedor_insumos p ON i.id_proveedor = p.id_proveedor
            GROUP BY p.id_proveedor"; // Agrupamos por proveedor

    $result = $this->conn->query($sql);
    
    $datosInventario = [];
    while ($row = $result->fetch_assoc()) {
        $datosInventario[] = [
            'proveedor' => $row['proveedor'],
            'totalInventario' => (int)$row['totalInventario']
        ];
    }

    return $datosInventario;
}


}
?>
