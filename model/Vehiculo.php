<?php
class Vehiculo {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    // Registrar vehículo
    public function agregar($placa, $cliente, $marca, $modelo) {
        $stmt = $this->conn->prepare(
            "INSERT INTO vehiculos (placa, cliente, marca, modelo) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("siss", $placa, $cliente, $marca, $modelo);
        $stmt->execute();
    }

    // Listar vehículos con nombre de cliente
    public function obtenerVehiculos() {
        $sql = "SELECT v.id, v.placa, v.marca, v.modelo, c.nombre AS cliente
                FROM vehiculos v
                INNER JOIN clientes c ON v.cliente = c.id
                ORDER BY v.id DESC";
        return $this->conn->query($sql);
    }

    // Obtener un vehículo 
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM vehiculos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Editar vehículo
    public function editar($id, $placa, $cliente, $marca, $modelo) {
        $stmt = $this->conn->prepare(
            "UPDATE vehiculos SET placa=?, cliente=?, marca=?, modelo=? WHERE id=?"
        );
        $stmt->bind_param("sissi", $placa, $cliente, $marca, $modelo, $id);
        $stmt->execute();
    }

    // Eliminar vehículo
    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM vehiculos WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    // Obtener vehículos de un cliente específico (por ID de cliente)
public function obtenerVehiculosPorCliente($clienteId) {
    $stmt = $this->conn->prepare(
        "SELECT v.id, v.placa, v.marca, v.modelo 
         FROM vehiculos v
         INNER JOIN clientes c ON v.cliente = c.id
         WHERE v.cliente = ?"
    );
    $stmt->bind_param("i", $clienteId);
    $stmt->execute();
    return $stmt->get_result();
}

}
