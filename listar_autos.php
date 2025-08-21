<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: index.php");
    exit;
}

// Obtenemos todos los autos
$stmt = $pdo->query("SELECT placa, marca, modelo, disponible, estado, foto
                     FROM autos
                     ORDER BY placa");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Autos</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .auto-foto {
            width: 120px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🚗 Listado de Autos</h1>

    <table>
        <tr>
            <th>Placa</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Disponible</th>
            <th>Estado</th>
            <th>Foto</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['placa']) ?></td>
                <td><?= htmlspecialchars($row['marca']) ?></td>
                <td><?= htmlspecialchars($row['modelo']) ?></td>
                <td><?= $row['disponible'] ? '✅ Sí' : '❌ No' ?></td>
                <td><?= htmlspecialchars($row['estado']) ?></td>
                <td>
                    <?php if (!empty($row['foto'])): ?>
                        <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto" class="auto-foto">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="empleado.php">⬅ Volver</a>
</div>
</body>
</html>
