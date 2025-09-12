<?php
require_once("../model/Cita.php");
require_once("../model/Conexion.php");

$citaModel = new Cita();

// Guardar nueva cita
if (isset($_POST['agendar'])) {
    $cliente_id  = $_POST['cliente_id'];
    $vehiculo_id = $_POST['vehiculo_id'];
    $servicio_id = $_POST['servicio_id'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
    $descripcion = $_POST['descripcion'];

    $id_mecanico = $citaModel->asignarMecanico($fecha);

    $citaModel->agendar($cliente_id, $vehiculo_id, $servicio_id, $fecha, $hora, $descripcion, $id_mecanico);

    header("Location: ../views/CitaView.php?msg=Cita guardada correctamente");
    exit;
}

// Editar cita
if (isset($_POST['editar'])) {
    $id          = $_POST['id'];
    $cliente_id  = $_POST['cliente_id'];
    $vehiculo_id = $_POST['vehiculo_id'];
    $servicio_id = $_POST['servicio_id'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
    $descripcion = $_POST['descripcion'];

    $id_mecanico = $citaModel->asignarMecanico($fecha);

    $citaModel->editarCita($id, $cliente_id, $vehiculo_id, $servicio_id, $fecha, $hora, $descripcion, $id_mecanico);

    header("Location: ../views/CitaView.php?msg=Cita actualizada correctamente");
    exit;
}

// Eliminar cita
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $citaModel->eliminarCita($id);

    header("Location: ../views/CitaView.php?msg=Cita eliminada");
    exit;
}

// Completar cita → generar servicio real
if (isset($_GET['completar'])) {
    $id_cita = intval($_GET['completar']);
    $cita    = $citaModel->obtenerCitaPorId($id_cita);

    if ($cita) {
        $conn = Conexion::conectar();

        // 1. Cambiar estado
        $stmt = $conn->prepare("UPDATE citas SET estado='Completada' WHERE id=?");
        $stmt->bind_param("i", $id_cita);
        $stmt->execute();

        // 2. Crear servicio real
        $stmt2 = $conn->prepare(
            "INSERT INTO servicios (vehiculo_id, descripcion, fecha, costo) VALUES (?, ?, ?, 0.00)"
        );
        $stmt2->bind_param("iss", $cita['vehiculo_id'], $cita['descripcion'], $cita['fecha']);
        $stmt2->execute();
    }

    header("Location: ../views/CitaView.php?msg=Cita completada y servicio registrado");
    exit;
}
