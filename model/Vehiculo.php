<?php
include_once 'Conexion.php';
class Vehiculo {
  public static function listar() {
    $conn = Conexion::conectar();
    $res = $conn->query("SELECT * FROM vehiculos");
    $datos = [];
    while ($row = $res->fetch_assoc()) {
      $datos[] = $row;
    }
    return $datos;
  }
}
?>