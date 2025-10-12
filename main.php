<?php
include './components/navbar.php';
// Incluir el controlador del Dashboard para obtener datos y pasar a la vista
include('./controller/DashboardController.php');



$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
date_default_timezone_set('America/El_Salvador');
$hora = date("d/m/Y H:i:s");


?>

