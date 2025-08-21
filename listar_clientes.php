<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'atencion') {
    header("Location: index.php");
    exit;
}

// Aquí usamos $pdo (de conexion.php), NO $conn
$stmt = $pdo->query("SELECT dpi, nombres, apellidos, telefono, correo
                     FROM clientes
                     ORDER BY apellidos, nombres");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h1>👥 Listado de Clientes</h1>

    <table>
        <tr>
            <th>DPI</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Correo</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['dpi']) ?></td>
                <td><?= htmlspecialchars($row['nombres']) ?></td>
                <td><?= htmlspecialchars($row['apellidos']) ?></td>
                <td><?= htmlspecialchars($row['telefono']) ?></td>
                <td><?= $row['correo'] ? htmlspecialchars($row['correo']) : "-" ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="empleado.php">⬅ Vol
