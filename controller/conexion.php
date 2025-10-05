<?php
$conexion = new mysqli("localhost", "root", "", "taller");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

<!-- /* 
<?php
class Conexion {
    public static function conectar() {
        $host = "sql305.infinityfree.com";
        $usuario = "if0_39941451";
        $password = "Ym7PnnZpKD1";
        $base_datos = "if0_39941451_taller";

        $Conexion = new mysqli($host, $usuario, $password, $base_datos);

        if ($Conexion->connect_error) {
            die("Error de conexión: " . $Conexion->connect_error);
        }
        return $Conexion;
    }
}
?>

*/ -->