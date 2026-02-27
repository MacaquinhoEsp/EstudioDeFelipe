<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin.php');
    exit;
}
include 'config_clientes.php';

// Procesar formulario de añadir cliente
if (isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']);
    $como_conocio = trim($_POST['como_conocio']);
    $notas = trim($_POST['notas']);
    $servicio = trim($_POST['servicio'] ?? '');
    $precio = !empty($_POST['precio']) ? floatval($_POST['precio']) : null;
    $fecha_servicio = !empty($_POST['fecha_servicio']) ? $_POST['fecha_servicio'] : null;

    if (!empty($nombre)) {
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, telefono, email, direccion, como_conocio, notas, servicio, precio, fecha_servicio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssds", $nombre, $telefono, $email, $direccion, $como_conocio, $notas, $servicio, $precio, $fecha_servicio);
        $stmt->execute();
        $stmt->close();
        $mensaje = "Cliente añadido correctamente.";
    } else {
        $error = "El nombre es obligatorio.";
    }
}

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM clientes WHERE id = $id");
    $mensaje = "Cliente eliminado.";
}

// Procesar edición (mostrar formulario con datos)
$editando = false;
$datos_edicion = [];
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $result = $conn->query("SELECT * FROM clientes WHERE id = $id");
    if ($result->num_rows > 0) {
        $editando = true;
        $datos_edicion = $result->fetch_assoc();
    }
}

// Procesar actualización
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']);
    $como_conocio = trim($_POST['como_conocio']);
    $notas = trim($_POST['notas']);
    $servicio = trim($_POST['servicio'] ?? '');
    $precio = !empty($_POST['precio']) ? floatval($_POST['precio']) : null;
    $fecha_servicio = !empty($_POST['fecha_servicio']) ? $_POST['fecha_servicio'] : null;

    if (!empty($nombre)) {
        $stmt = $conn->prepare("UPDATE clientes SET nombre=?, telefono=?, email=?, direccion=?, como_conocio=?, notas=?, servicio=?, precio=?, fecha_servicio=? WHERE id=?");
        $stmt->bind_param("sssssssdsi", $nombre, $telefono, $email, $direccion, $como_conocio, $notas, $servicio, $precio, $fecha_servicio, $id);
        $stmt->execute();
        $stmt->close();
        $mensaje = "Cliente actualizado.";
        header("Location: clientes.php");
        exit;
    } else {
        $error = "El nombre es obligatorio.";
    }
}

// Buscar clientes
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$filtro_servicio = isset($_GET['filtro_servicio']) ? $_GET['filtro_servicio'] : '';

$sql = "SELECT * FROM clientes WHERE 1=1";
if ($busqueda) {
    $busqueda_segura = $conn->real_escape_string($busqueda);
    $sql .= " AND (nombre LIKE '%$busqueda_segura%' OR email LIKE '%$busqueda_segura%' OR telefono LIKE '%$busqueda_segura%')";
}
if ($filtro_servicio) {
    $filtro_seguro = $conn->real_escape_string($filtro_servicio);
    $sql .= " AND servicio = '$filtro_seguro'";
}
$sql .= " ORDER BY nombre";
$resultados = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes · Estudio Felipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: "Inter", sans-serif; }
        h1, h2, .font-serif { font-family: "Playfair Display", serif; }
        body { background-color: #fcf9f5; }
    </style>
</head>
<body class="bg-[#fcf9f5] text-[#2f2a25] p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-serif">Gestión de Clientes</h1>
            <div class="flex gap-4">
                <a href="admin.php" class="bg-[#c9a87c] text-white px-4 py-2 rounded-full text-sm hover:bg-[#b59573] transition">
                    <i class="fas fa-tachometer-alt"></i> Panel principal
                </a>
                <a href="home.html" class="bg-[#c9a87c] text-white px-4 py-2 rounded-full text-sm hover:bg-[#b59573] transition">
                    Volver a la web
                </a>
            </div>
        </div>

        <!-- Mostrar mensajes -->
        <?php if (isset($mensaje)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4"><?= $mensaje ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4"><?= $error ?></div>
        <?php endif; ?>

        <!-- Formulario de añadir/editar cliente -->
        <div class="bg-white/80 backdrop-blur-sm p-6 rounded-3xl shadow-xl border border-white/60 mb-8">
            <h2 class="text-2xl font-serif mb-4"><?= $editando ? 'Editar cliente' : 'Añadir nuevo cliente' ?></h2>
            <form method="POST" action="clientes.php" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php if ($editando): ?>
                    <input type="hidden" name="id" value="<?= $datos_edicion['id'] ?>">
                <?php endif; ?>
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="<?= $editando ? htmlspecialchars($datos_edicion['nombre']) : '' ?>" required class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="<?= $editando ? htmlspecialchars($datos_edicion['telefono']) : '' ?>" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Email</label>
                    <input type="email" name="email" value="<?= $editando ? htmlspecialchars($datos_edicion['email']) : '' ?>" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Dirección</label>
                    <input type="text" name="direccion" value="<?= $editando ? htmlspecialchars($datos_edicion['direccion']) : '' ?>" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">¿Cómo nos conoció?</label>
                    <input type="text" name="como_conocio" value="<?= $editando ? htmlspecialchars($datos_edicion['como_conocio']) : '' ?>" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Tipo de servicio</label>
                    <select name="servicio" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                        <option value="">-- Selecciona --</option>
                        <option value="Comunión" <?= ($editando && $datos_edicion['servicio']=='Comunión')?'selected':'' ?>>Comunión</option>
                        <option value="Retrato" <?= ($editando && $datos_edicion['servicio']=='Retrato')?'selected':'' ?>>Retrato</option>
                        <option value="Infantil" <?= ($editando && $datos_edicion['servicio']=='Infantil')?'selected':'' ?>>Infantil</option>
                        <option value="Cuentos" <?= ($editando && $datos_edicion['servicio']=='Cuentos')?'selected':'' ?>>Cuentos</option>
                        <option value="Al aire" <?= ($editando && $datos_edicion['servicio']=='Al aire')?'selected':'' ?>>Al aire</option>
                        <option value="Fotos carnet" <?= ($editando && $datos_edicion['servicio']=='Fotos carnet')?'selected':'' ?>>Fotos carnet</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Precio (€)</label>
                    <input type="number" step="0.01" name="precio" value="<?= $editando ? htmlspecialchars($datos_edicion['precio']) : '' ?>" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Fecha del servicio</label>
                    <input type="date" name="fecha_servicio" value="<?= $editando ? htmlspecialchars($datos_edicion['fecha_servicio']) : '' ?>" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-[#5b4f46] mb-1">Notas</label>
                    <textarea name="notas" rows="2" class="w-full p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]"><?= $editando ? htmlspecialchars($datos_edicion['notas']) : '' ?></textarea>
                </div>
                <div class="md:col-span-3 flex gap-4">
                    <button type="submit" name="<?= $editando ? 'actualizar' : 'guardar' ?>" class="bg-[#c9a87c] hover:bg-[#b48d62] text-white px-6 py-3 rounded-full font-semibold transition-all shadow-lg">
                        <?= $editando ? 'Actualizar cliente' : 'Guardar cliente' ?>
                    </button>
                    <?php if ($editando): ?>
                        <a href="clientes.php" class="border border-[#c9a87c] text-[#c9a87c] hover:bg-[#c9a87c] hover:text-white px-6 py-3 rounded-full font-semibold transition-all">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Buscador y filtros -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <form method="GET" action="clientes.php" class="md:col-span-2 flex gap-2">
                <input type="text" name="buscar" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar por nombre, email o teléfono..." class="flex-1 p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                <button type="submit" class="bg-[#c9a87c] hover:bg-[#b48d62] text-white px-6 py-3 rounded-2xl font-semibold transition-all shadow-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <form method="GET" action="clientes.php" class="flex gap-2">
                <select name="filtro_servicio" class="flex-1 p-3 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c]">
                    <option value="">Todos los servicios</option>
                    <option value="Comunión" <?= ($filtro_servicio=='Comunión')?'selected':'' ?>>Comunión</option>
                    <option value="Retrato" <?= ($filtro_servicio=='Retrato')?'selected':'' ?>>Retrato</option>
                    <option value="Infantil" <?= ($filtro_servicio=='Infantil')?'selected':'' ?>>Infantil</option>
                    <option value="Cuentos" <?= ($filtro_servicio=='Cuentos')?'selected':'' ?>>Cuentos</option>
                    <option value="Al aire" <?= ($filtro_servicio=='Al aire')?'selected':'' ?>>Al aire</option>
                    <option value="Fotos carnet" <?= ($filtro_servicio=='Fotos carnet')?'selected':'' ?>>Fotos carnet</option>
                </select>
                <button type="submit" class="bg-[#c9a87c] hover:bg-[#b48d62] text-white px-6 py-3 rounded-2xl font-semibold transition-all shadow-lg">
                    Filtrar
                </button>
                <?php if ($busqueda || $filtro_servicio): ?>
                    <a href="clientes.php" class="border border-[#c9a87c] text-[#c9a87c] hover:bg-[#c9a87c] hover:text-white px-6 py-3 rounded-2xl font-semibold transition-all">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Botón de exportar emails -->
        <div class="mb-4 text-right">
            <a href="exportar_emails.php?buscar=<?= urlencode($busqueda) ?>&filtro_servicio=<?= urlencode($filtro_servicio) ?>" 
               class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-semibold transition-all shadow-lg">
                <i class="fas fa-download mr-2"></i> Exportar emails (CSV)
            </a>
        </div>

        <!-- Listado de clientes -->
        <div class="bg-white/80 backdrop-blur-sm p-6 rounded-3xl shadow-xl border border-white/60 overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase tracking-wider text-[#b59573]">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Servicio</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">Fecha servicio</th>
                        <th class="px-4 py-3">Registro</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-[#5b4f46]">
                    <?php if ($resultados->num_rows > 0): ?>
                        <?php while ($row = $resultados->fetch_assoc()): ?>
                            <tr class="border-b border-[#e1cfbc] hover:bg-white/50 transition">
                                <td class="px-4 py-3"><?= $row['id'] ?></td>
                                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['nombre']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['telefono'] ?? '-') ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['servicio'] ?? '-') ?></td>
                                <td class="px-4 py-3"><?= $row['precio'] ? number_format($row['precio'],2) . ' €' : '-' ?></td>
                                <td class="px-4 py-3"><?= $row['fecha_servicio'] ? date('d/m/Y', strtotime($row['fecha_servicio'])) : '-' ?></td>
                                <td class="px-4 py-3"><?= date('d/m/Y', strtotime($row['fecha_registro'])) ?></td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="?editar=<?= $row['id'] ?>" class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></a>
                                    <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este cliente?')" class="text-red-600 hover:underline"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center py-6 text-[#8b755e]">No hay clientes registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>