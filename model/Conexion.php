<?php
class Conexion {
    public static function conectar() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "taller";

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        return $conn;
    }
}
