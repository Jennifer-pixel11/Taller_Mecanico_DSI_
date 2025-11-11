<?php
class Cliente {
    private $conn;

    public function __construct() {
        include_once("Conexion.php");
        $this->conn = Conexion::conectar();
    }

    // Registrar cliente
    public function agregar($nombre, $telefono, $correo, $direccion) {
        $stmt = $this->conn->prepare(
            "INSERT INTO clientes (nombre, telefono, correo, direccion) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $nombre, $telefono, $correo, $direccion);
        $stmt->execute();
    }

    // Listar clientes
    public function obtenerClientes() {
        $sql = "SELECT * FROM clientes ORDER BY id DESC";
        return $this->conn->query($sql);
    }

      // ✅ NUEVO: Obtener los últimos clientes registrados
    public function obtenerUltimosClientes($limite = 2) {
        $stmt = $this->conn->prepare("SELECT * FROM clientes ORDER BY id DESC LIMIT ?");
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Obtener un cliente por ID
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Editar cliente
    public function editar($id, $nombre, $telefono, $correo, $direccion) {
        $stmt = $this->conn->prepare(
            "UPDATE clientes SET nombre=?, telefono=?, correo=?, direccion=? WHERE id=?"
        );
        $stmt->bind_param("ssssi", $nombre, $telefono, $correo, $direccion, $id);
        $stmt->execute();
    }

    // Eliminar cliente
    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
