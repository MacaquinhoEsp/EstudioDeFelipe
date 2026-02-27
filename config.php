<?php
// config.php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_datos = "estudiofelipe_db"; // Cambia por el nombre real de tu BD de presupuestos

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>