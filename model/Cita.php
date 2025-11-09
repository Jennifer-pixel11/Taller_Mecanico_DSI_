<?php
class Cita {
    private $conn;

    public function __construct() {
        //include_once("Conexion.php");
        $this->conn = Conexion::conectar();
    }

    // Crear cita
    public function agendar($cliente_id, $vehiculo_id, $servicio_id, $fecha, $hora, $descripcion, $id_mecanico = null) {
        $stmt = $this->conn->prepare(
            "INSERT INTO citas (cliente_id, vehiculo_id, servicio_id, fecha, hora, descripcion, estado, id_mecanico) 
             VALUES (?, ?, ?, ?, ?, ?, 'Pendiente', ?)"
        );
        $stmt->bind_param("iiisssi", $cliente_id, $vehiculo_id, $servicio_id, $fecha, $hora, $descripcion, $id_mecanico);
        $stmt->execute();
    }

    // Listar citas con JOIN
    public function obtenerCitas() {
        $sql = "SELECT c.id,
                       cl.nombre AS cliente,
                       CONCAT(v.placa, ' - ', v.marca, ' ', v.modelo) AS vehiculo,
                       s.nombre AS servicio,
                       c.fecha, c.hora, c.descripcion, c.estado,
                       c.cliente_id, c.vehiculo_id, c.servicio_id
                FROM citas c
                INNER JOIN clientes cl ON c.cliente_id = cl.id
                INNER JOIN vehiculos v ON c.vehiculo_id = v.id
                INNER JOIN servicios_catalogo s ON c.servicio_id = s.id
                ORDER BY c.fecha, c.hora";
        return $this->conn->query($sql);
    }

    // Obtener cita por ID
    public function obtenerCitaPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM citas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Editar cita
    public function editarCita($id, $cliente_id, $vehiculo_id, $servicio_id, $fecha, $hora, $descripcion, $id_mecanico = null) {
        $stmt = $this->conn->prepare(
            "UPDATE citas 
             SET cliente_id=?, vehiculo_id=?, servicio_id=?, fecha=?, hora=?, descripcion=?, id_mecanico=? 
             WHERE id=?"
        );
        $stmt->bind_param("iiisssii", $cliente_id, $vehiculo_id, $servicio_id, $fecha, $hora, $descripcion, $id_mecanico, $id);
        $stmt->execute();
    }

    // Eliminar cita
    public function eliminarCita($id) {
        $stmt = $this->conn->prepare("DELETE FROM citas WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

   
    public function asignarMecanico($fecha) {
        $sql = "SELECT id FROM usuarios WHERE rol='Mecánico' LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['id'];
        }
        return null;
    }
}
