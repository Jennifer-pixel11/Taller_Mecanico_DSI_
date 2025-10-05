<?php
//require_once "Conexion.php";
include_once("Conexion.php");
class Inventario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Listar todos los productos
    public function listar() {
        $sql = "SELECT inventario.*, proveedor_insumos.nombre AS proveedor_nombre
                FROM inventario
                LEFT JOIN proveedor_insumos
                ON inventario.id_proveedor = proveedor_insumos.id_proveedor";
        return $this->conexion->query($sql);
    }

    // Listar proveedores
    public function listarProveedores() {
        $sql = "SELECT id_proveedor, nombre FROM proveedor_insumos";
        return $this->conexion->query($sql);
    }

    // Obtener producto por ID
    public function obtener($id) {
        $resultado = $this->conexion->query("SELECT * FROM inventario WHERE id = $id");
        return $resultado->fetch_assoc();
    }

    // Agregar producto
    public function agregar($data) {
        $sql = "INSERT INTO inventario (nombre, descripcion, cantidad, precio, imagen, id_proveedor)
                VALUES ('{$data['nombre']}', '{$data['descripcion']}', {$data['cantidad']}, {$data['precio']}, '{$data['imagen']}', {$data['id_proveedor']})";
        return $this->conexion->query($sql);
    }

    // Editar producto
    public function editar($id, $data) {
        $imagen_sql = isset($data['imagen']) ? ", imagen='{$data['imagen']}'" : "";
        $sql = "UPDATE inventario SET 
                    nombre='{$data['nombre']}', 
                    descripcion='{$data['descripcion']}', 
                    cantidad={$data['cantidad']}, 
                    precio={$data['precio']}, 
                    id_proveedor={$data['id_proveedor']}
                    $imagen_sql
                WHERE id=$id";
        return $this->conexion->query($sql);
    }

    // Eliminar producto
    public function eliminar($id) {
        return $this->conexion->query("DELETE FROM inventario WHERE id=$id");
    }
}
?>

