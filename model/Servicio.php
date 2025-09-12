<?php
class Servicio {
    private $conn;

    public function __construct() {
        include_once("Conexion.php");
        $this->conn = Conexion::conectar();
    }

    public function agregar($vehiculo_id, $descripcion, $fecha, $costo) {
        $stmt = $this->conn->prepare(
            "INSERT INTO servicios (vehiculo_id, descripcion, fecha, costo) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("issd", $vehiculo_id, $descripcion, $fecha, $costo);
        $stmt->execute();
    }

    // Listar servicios con cliente y vehículo
    public function obtenerServicios() {
        $sql = "SELECT s.id,
                       c.nombre AS cliente,
                       CONCAT(v.placa, ' - ', v.marca, ' ', v.modelo) AS vehiculo,
                       s.descripcion, s.fecha, s.costo
                FROM servicios s
                INNER JOIN vehiculos v ON s.vehiculo_id = v.id
                INNER JOIN clientes c ON v.cliente = c.id
                ORDER BY s.fecha DESC";
        return $this->conn->query($sql);
    }


    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM servicios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Editar servicio
    public function editar($id, $vehiculo_id, $descripcion, $fecha, $costo) {
        $stmt = $this->conn->prepare(
            "UPDATE servicios SET vehiculo_id=?, descripcion=?, fecha=?, costo=? WHERE id=?"
        );
        $stmt->bind_param("issdi", $vehiculo_id, $descripcion, $fecha, $costo, $id);
        $stmt->execute();
    }

    // Eliminar servicio
    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM servicios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
