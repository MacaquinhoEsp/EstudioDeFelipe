<?php
// config_clientes.php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_datos = "estudio_clientes_db"; // Nombre de la BD de clientes

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>