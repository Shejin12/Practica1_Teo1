<?php
require 'conexion.php';
session_start();

$clientes = $pdo->query("SELECT dpi, nombres, apellidos FROM clientes")->fetchAll(PDO::FETCH_ASSOC);

$autos = $pdo->query("SELECT placa, marca, modelo FROM autos WHERE disponible = TRUE")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dpi_cliente = $_POST['dpi_cliente'];
    $id_auto = $_POST['placa'];
    $dpi_empleado = $_SESSION['dpi'];
    $hora_salida = $_POST['hora_salida'];
    $hora_estimada_llegada = $_POST['hora_estimada_llegada'];

    $inicio = new DateTime($hora_salida);
    $fin_estimado = new DateTime($hora_estimada_llegada);
    $horas = $inicio->diff($fin_estimado)->h;
    if ($inicio->diff($fin_estimado)->days > 0) {
        $horas += $inicio->diff($fin_estimado)->days * 24;
    }
    $costo = $horas * 25;

    $stmt = $pdo->prepare("INSERT INTO alquileres (dpi_empleado, dpi_cliente, placa, hora_salida, hora_estimada_llegada, costo)
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$dpi_empleado, $dpi_cliente, $$id_auto, $hora_salida, $hora_estimada_llegada, $costo]);

    $pdo->prepare("UPDATE autos SET disponible = FALSE WHERE placa = ?")->execute([$placa]);

    header("Location: listar_alquileres.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Alquiler</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h1>Nuevo Alquiler</h1>
    <form method="post">
        <label>Cliente:</label>
        <select name="dpi_cliente" required>
            <option value="">Seleccione...</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= htmlspecialchars($c['dpi']) ?>">
                    <?= htmlspecialchars($c['nombres'] . " " . $c['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Auto:</label>
        <select name="id_auto" required>
        <option value="">Seleccione...</option>
        <?php foreach ($autos as $a): ?>
            <option value="<?= htmlspecialchars($a['id_auto']) ?>">
                <?= htmlspecialchars($a['placa'] . " - " . $a['marca'] . " " . $a['modelo']) ?>
            </option>
        <?php endforeach; ?>
    </select>


        <label>Hora de salida:</label>
        <input type="datetime-local" name="hora_salida" required>

        <label>Hora estimada de llegada:</label>
        <input type="datetime-local" name="hora_estimada_llegada" required>

        <button type="submit">Guardar Alquiler</button>
    </form>
    <br>
    <a href="empleado.php">⬅ Volver</a>
</div>
</body>
</html>
