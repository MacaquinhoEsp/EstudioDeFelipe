<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'] ?? null;
    $tipo_sesion = $_POST['tipo_sesion'] ?? null;
    $mensaje = $_POST['mensaje'] ?? null;

    $stmt = $conn->prepare("INSERT INTO presupuestos (nombre, email, telefono, tipo_sesion, mensaje) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $tipo_sesion, $mensaje);

    if ($stmt->execute()) {
        // Redirigir a la página de gracias
        header("Location: gracias.html");
        exit;
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No se recibieron datos.";
}
?>