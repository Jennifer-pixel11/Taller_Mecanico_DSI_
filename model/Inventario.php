<?php

require_once __DIR__ . "/Conexion.php";

class Inventario {
  private $conn;

  public function __construct() {
    $this->conn = Conexion::conectar();
  }

  public function obtenerTodos() {
    $sql = "SELECT i.*, p.nombre AS nombre_proveedor
            FROM inventario i
            LEFT JOIN proveedor_insumos p ON i.id_proveedor = p.id_proveedor
            ORDER BY i.id DESC";
    return $this->conn->query($sql);
  }

  public function obtenerPorId($id) {
    $stmt = $this->conn->prepare("SELECT * FROM inventario WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  public function obtenerProveedores() {
    return $this->conn->query("SELECT id_proveedor, nombre FROM proveedor_insumos ORDER BY nombre ASC");
  }

  public function agregar($nombre, $descripcion, $cantidad, $cantidad_minima, $precio, $imagen, $id_proveedor) {
    $stmt = $this->conn->prepare("INSERT INTO inventario (nombre, descripcion, cantidad, cantidad_minima, precio, imagen, id_proveedor) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("ssiidss", $nombre, $descripcion, $cantidad, $cantidad_minima, $precio, $imagen, $id_proveedor);
    return $stmt->execute();
  }

  public function actualizar($id, $nombre, $descripcion, $cantidad, $cantidad_minima, $precio, $imagen, $id_proveedor) {
    $stmt = $this->conn->prepare("UPDATE inventario SET nombre=?, descripcion=?, cantidad=?, cantidad_minima=?, precio=?, imagen=?, id_proveedor=? WHERE id=?");
    $stmt->bind_param("ssiidssi", $nombre, $descripcion, $cantidad, $cantidad_minima, $precio, $imagen, $id_proveedor, $id);
    return $stmt->execute();
  }

  public function eliminar($id) {
    $stmt = $this->conn->prepare("DELETE FROM inventario WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
