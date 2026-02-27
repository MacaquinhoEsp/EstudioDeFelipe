<?php
session_start();
include 'config.php';

// Contraseña correcta (cámbiala por la que quieras)
$password_correcta = 'estudio2026';

// Procesar login
if (isset($_POST['login'])) {
    if ($_POST['password'] === $password_correcta) {
        $_SESSION['admin'] = true;
    } else {
        $error = "Contraseña incorrecta";
    }
}

// Procesar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Procesar actualización de estado
if (isset($_POST['actualizar_estado']) && isset($_POST['id']) && isset($_POST['estado'])) {
    $id = intval($_POST['id']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);
    $update = "UPDATE presupuestos SET estado = '$estado' WHERE id = $id";
    mysqli_query($conn, $update);
    $mensaje = "Estado actualizado correctamente.";
}

// Comprobar si está logueado
$logueado = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin · Estudio Felipe</title>
    <!-- Tailwind + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: "Inter", sans-serif; }
        h1, h2, .font-serif { font-family: "Playfair Display", serif; }
        body { background-color: #fcf9f5; }
        table th { background-color: #f0e4d5; }
    </style>
</head>
<body class="bg-[#fcf9f5] text-[#2f2a25]">

<?php if (!$logueado): ?>

    <!-- PANTALLA DE LOGIN -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white/80 backdrop-blur-sm p-10 rounded-3xl shadow-2xl border border-white/60 max-w-md w-full">
            <div class="text-center mb-8">
                <img src="img/sombrero.png" alt="Estudio Felipe" class="h-16 mx-auto mb-4 opacity-80">
                <h1 class="text-3xl font-serif">Acceso restringido</h1>
                <div class="w-20 h-0.5 bg-[#c9a87c] mx-auto mt-3"></div>
            </div>
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <input type="password" name="password" placeholder="Contraseña" required
                       class="w-full p-4 rounded-2xl border border-[#e2cfbb] bg-white/90 focus:outline-none focus:ring-2 focus:ring-[#c9a87c] mb-4">
                <button type="submit" name="login"
                        class="w-full bg-[#c9a87c] hover:bg-[#b48d62] text-white py-4 rounded-2xl font-semibold transition-all shadow-xl flex items-center justify-center gap-3">
                    <i class="fas fa-lock"></i> Entrar
                </button>
            </form>
        </div>
    </div>

<?php else: ?>

    <!-- PANEL PRINCIPAL (logueado) -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Cabecera del panel con enlace a clientes -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <img src="img/sombrero.png" alt="Estudio Felipe" class="h-12">
                <h1 class="text-3xl font-serif">Presupuestos recibidos</h1>
            </div>
            <div class="flex gap-4 mt-4 md:mt-0">
                <a href="clientes.php" class="bg-[#c9a87c] hover:bg-[#b48d62] text-white px-6 py-2 rounded-full transition flex items-center gap-2">
                    <i class="fas fa-users"></i> Gestión de clientes
                </a>
                <a href="?logout=1" class="bg-red-100 text-red-600 px-6 py-2 rounded-full hover:bg-red-200 transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
            </div>
        </div>

        <?php if (isset($mensaje)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <?php
        // Obtener todos los presupuestos ordenados por fecha descendente
        $result = mysqli_query($conn, "SELECT * FROM presupuestos ORDER BY fecha DESC");
        if (mysqli_num_rows($result) == 0): ?>
            <div class="text-center py-20 bg-white/50 rounded-3xl">
                <i class="fas fa-inbox text-6xl text-[#c9a87c] opacity-30 mb-4"></i>
                <p class="text-xl text-[#8b755e]">No hay solicitudes todavía</p>
            </div>
        <?php else: ?>

        <!-- Tabla de presupuestos -->
        <div class="overflow-x-auto bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/60 p-6">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase tracking-wider text-[#b59573]">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Mensaje</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Acción</th>
                    </tr>
                </thead>
                <tbody class="text-[#5b4f46]">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="border-b border-[#e1cfbc] hover:bg-white/50 transition">
                        <td class="px-4 py-3 whitespace-nowrap"><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
                        <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['nombre']) ?></td>
                        <td class="px-4 py-3"><a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="text-[#c9a87c] hover:underline"><?= htmlspecialchars($row['email']) ?></a></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($row['telefono'] ?? '-') ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($row['tipo_sesion'] ?? '-') ?></td>
                        <td class="px-4 py-3 max-w-xs truncate"><?= htmlspecialchars($row['mensaje'] ?? '-') ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                <?php
                                switch ($row['estado']) {
                                    case 'Pendiente': echo 'bg-yellow-100 text-yellow-700'; break;
                                    case 'Respondido': echo 'bg-blue-100 text-blue-700'; break;
                                    case 'Contratado': echo 'bg-green-100 text-green-700'; break;
                                    default: echo 'bg-gray-100 text-gray-700';
                                }
                                ?>">
                                <?= htmlspecialchars($row['estado']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <form method="POST" action="" class="flex items-center gap-2">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="estado" class="text-sm border border-[#e2cfbb] rounded-lg p-1 bg-white">
                                    <option value="Pendiente" <?= $row['estado']=='Pendiente'?'selected':'' ?>>Pendiente</option>
                                    <option value="Respondido" <?= $row['estado']=='Respondido'?'selected':'' ?>>Respondido</option>
                                    <option value="Contratado" <?= $row['estado']=='Contratado'?'selected':'' ?>>Contratado</option>
                                </select>
                                <button type="submit" name="actualizar_estado" class="bg-[#c9a87c] text-white px-3 py-1 rounded-lg text-xs hover:bg-[#b48d62] transition">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

<?php endif; ?>
</body>
</html>