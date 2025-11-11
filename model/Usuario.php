<?php
class Usuario {
    private $conn;

    public function __construct() {
        include_once("Conexion.php");
        $this->conn = Conexion::conectar();
    }

    
    public function crearUsuario($usuario, $correo, $telefono, $clave, $rol){
    // Verificar si el usuario ya existe
    $sqlCheck = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmtCheck = $this->conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $usuario);
    $stmtCheck->execute();
    $resultado = $stmtCheck->get_result();

    // Si ya existe, simplemente devolvemos un mensaje y evitamos el error
    if ($resultado->num_rows > 0) {
        return "existe";
    }

    // Si no existe, se crea
    $sql = "INSERT INTO usuarios (usuario, correo, telefono, clave, rol)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("sssss", $usuario, $correo, $telefono, $clave,  $rol);
    $stmt->execute();

    return $stmt->affected_rows > 0 ? "creado" : "error";
}

}
?>
