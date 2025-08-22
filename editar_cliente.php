<?php
require 'conexion.php';

$dpi = $_GET['dpi'] ?? null;

if (!$dpi) {
    die("DPI no proporcionado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "UPDATE clientes 
            SET nombres=:nombres, apellidos=:apellidos, telefono=:telefono, correo=:correo
            WHERE dpi=:dpi";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombres' => $nombres,
        ':apellidos' => $apellidos,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':dpi' => $dpi
    ]);

    header("Location: listar_clientes.php");
    exit();
} else {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE dpi=:dpi");
    $stmt->execute([':dpi' => $dpi]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cliente) die("Cliente no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h1>Editar Cliente</h1>
        <form method="POST">
            <input type="text" name="nombres" value="<?= htmlspecialchars($cliente['nombres']) ?>" required>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($cliente['apellidos']) ?>" required>
            <input type="text" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
            <input type="email" name="correo" value="<?= htmlspecialchars($cliente['correo']) ?>" required>
            <button type="submit">Actualizar Cliente</button>
        </form>
    <a href="listar_clientes.php">Volver</a>
</div>
</body>
</html>
