<?php
class Comprobante {
    private $conn;

    public function __construct() {
        include_once("Conexion.php");
        $this->conn = Conexion::conectar();
    }

    // Crear comprobante
    public function generar($servicio_id, $total) {
        // Número correlativo FACT-0001, FACT-0002...
        $sql = "SELECT COUNT(*) AS total FROM comprobantes";
        $res = $this->conn->query($sql)->fetch_assoc();
        $numero = "FACT-" . str_pad($res['total'] + 1, 4, "0", STR_PAD_LEFT);

        $stmt = $this->conn->prepare(
            "INSERT INTO comprobantes (servicio_id, numero, total) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("isd", $servicio_id, $numero, $total);
        $stmt->execute();

        return $this->conn->insert_id;
    }

    // Obtener comprobante por ID
    public function obtenerPorId($id) {
        $sql = "SELECT comp.id, comp.numero, comp.fecha_emision, comp.total,
                       c.nombre AS cliente, c.telefono, c.correo,
                       v.placa, v.marca, v.modelo,
                       s.descripcion, s.fecha
                FROM comprobantes comp
                INNER JOIN servicios s ON comp.servicio_id = s.id
                INNER JOIN vehiculos v ON s.vehiculo_id = v.id
                INNER JOIN clientes c ON v.cliente = c.id
                WHERE comp.id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Listar comprobantes
    public function listar() {
        $sql = "SELECT comp.id, comp.numero, comp.fecha_emision, comp.total,
                       c.nombre AS cliente, v.placa
                FROM comprobantes comp
                INNER JOIN servicios s ON comp.servicio_id = s.id
                INNER JOIN vehiculos v ON s.vehiculo_id = v.id
                INNER JOIN clientes c ON v.cliente = c.id
                ORDER BY comp.fecha_emision DESC";
        return $this->conn->query($sql);
    }
}
