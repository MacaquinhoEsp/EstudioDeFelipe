<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin.php');
    exit;
}
include 'config_clientes.php';

// Recibir filtros desde la URL (igual que en clientes.php)
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$filtro_servicio = isset($_GET['filtro_servicio']) ? $_GET['filtro_servicio'] : '';

// Construir la consulta SQL con los mismos filtros
$sql = "SELECT nombre, email, telefono, servicio FROM clientes WHERE email IS NOT NULL AND email != ''";
if ($busqueda) {
    $busqueda_segura = $conn->real_escape_string($busqueda);
    $sql .= " AND (nombre LIKE '%$busqueda_segura%' OR email LIKE '%$busqueda_segura%' OR telefono LIKE '%$busqueda_segura%')";
}
if ($filtro_servicio) {
    $filtro_seguro = $conn->real_escape_string($filtro_servicio);
    $sql .= " AND servicio = '$filtro_seguro'";
}
$sql .= " ORDER BY nombre";

$result = $conn->query($sql);

// Configurar cabeceras para descargar un archivo CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=emails_clientes_' . date('Y-m-d') . '.csv');

// Crear el archivo CSV en la salida (output)
$output = fopen('php://output', 'w');

// Poner la primera fila con los títulos de las columnas
fputcsv($output, ['Nombre', 'Email', 'Teléfono', 'Servicio']);

// Recorrer los resultados y escribir cada fila
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['nombre'],
            $row['email'],
            $row['telefono'],
            $row['servicio']
        ]);
    }
} else {
    // Si no hay resultados, al menos una fila indicándolo
    fputcsv($output, ['No hay emails con los filtros seleccionados']);
}

fclose($output);
exit;
?>