<?php
// model/Proveedor.php
require_once 'Conexion.php';
class Proveedor {
	private $conn;

	public function __construct() {
		$this->conn = Conexion::conectar();
	}

	// Obtener todos los proveedores
	public function obtenerProveedores() {
		$sql = "SELECT * FROM proveedor_insumos";
		return $this->conn->query($sql);
	}

	// Obtener proveedor por ID
	public function obtenerPorId($id) {
		$stmt = $this->conn->prepare("SELECT * FROM proveedor_insumos WHERE id_proveedor = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	// Agregar proveedor
	public function agregarProveedor($nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro) {
		$stmt = $this->conn->prepare("INSERT INTO proveedor_insumos (nombre, nombre_contacto, telefono, correo_electronico, direccion, rubro) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro);
		return $stmt->execute();
	}

	// Actualizar proveedor
	public function actualizarProveedor($id, $nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro) {
		$stmt = $this->conn->prepare("UPDATE proveedor_insumos SET nombre=?, nombre_contacto=?, telefono=?, correo_electronico=?, direccion=?, rubro=? WHERE id_proveedor=?");
		$stmt->bind_param("ssssssi", $nombre, $nombre_contacto, $telefono, $correo_electronico, $direccion, $rubro, $id);
		return $stmt->execute();
	}

	// Eliminar proveedor
	public function eliminarProveedor($id) {
		$stmt = $this->conn->prepare("DELETE FROM proveedor_insumos WHERE id_proveedor = ?");
		$stmt->bind_param("i", $id);
		return $stmt->execute();
	}
}

