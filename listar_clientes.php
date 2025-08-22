<?php
require 'conexion.php';

$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h1>Lista de Clientes</h1>
    <div class="table-container">
        <table>
            <tr>
                <th>DPI</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($clientes as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['dpi']) ?></td>
                <td><?= htmlspecialchars($row['nombres']) ?></td>
                <td><?= htmlspecialchars($row['apellidos']) ?></td>
                <td><?= htmlspecialchars($row['telefono']) ?></td>
                <td><?= htmlspecialchars($row['correo']) ?></td>
                <td>
                    <a class="btn-edit" href="editar_cliente.php?dpi=<?= $row['dpi'] ?>">Editar</a>
                    <a class="btn-delete" href="eliminar_cliente.php?dpi=<?= $row['dpi'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a class="btn" href="crear_cliente.php">Nuevo Cliente</a>
    <a class="btn" href="empleado.php">Volver</a>
</div>
</body>
</html>
