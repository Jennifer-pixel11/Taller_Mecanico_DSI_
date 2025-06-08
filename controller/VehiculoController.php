<?php
include_once '../model/Vehiculo.php';
if ($_GET['action'] === 'list') {
  echo json_encode(Vehiculo::listar());
}
?>