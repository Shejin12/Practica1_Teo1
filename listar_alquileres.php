<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'atencion') {
    header("Location: index.php");
    exit;
}

$sql = "SELECT a.id_alquiler,
               c.nombres  AS cliente,  c.apellidos  AS cliente_apellido,
               e.nombres  AS empleado, e.apellidos  AS empleado_apellido,
               au.placa, au.marca, au.modelo,
               a.hora_salida, a.hora_llegada, a.total_cobrado
        FROM alquileres a
        INNER JOIN clientes  c ON a.dpi_cliente  = c.dpi
        INNER JOIN empleados e ON a.dpi_empleado = e.dpi
        INNER JOIN autos     au ON a.placa_auto  = au.placa
        ORDER BY a.id_alquiler DESC";

$stmt = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Alquileres</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h1>Listado de Alquileres</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Empleado</th>
            <th>Auto</th>
            <th>Salida</th>
            <th>Llegada</th>
            <th>Total Cobrado</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id_alquiler']) ?></td>
                <td><?= htmlspecialchars($row['cliente'] . " " . $row['cliente_apellido']) ?></td>
                <td><?= htmlspecialchars($row['empleado'] . " " . $row['empleado_apellido']) ?></td>
                <td><?= htmlspecialchars($row['placa'] . " (" . $row['marca'] . " " . $row['modelo'] . ")") ?></td>
                <td><?= htmlspecialchars($row['hora_salida']) ?></td>
                <td><?= $row['hora_llegada'] ? htmlspecialchars($row['hora_llegada']) : "En curso" ?></td>
                <td><?= $row['total_cobrado'] !== null ? "Q" . number_format((float)$row['total_cobrado'], 2) : "-" ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="empleado.php">⬅ Volver</a>
</div>
</body>
</html>
