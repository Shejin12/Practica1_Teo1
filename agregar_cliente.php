<?php
require 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dpi = $_POST['dpi'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];

    $stmt = $pdo->prepare("INSERT INTO clientes (dpi, nombres, apellidos, telefono) VALUES (?, ?, ?, ?)");
    $stmt->execute([$dpi, $nombres, $apellidos, $telefono]);

    header("Location: listar_clientes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h1>Agregar Cliente</h1>
    <form method="post">
        <label>DPI:</label>
        <input type="text" name="dpi" required>

        <label>Nombres:</label>
        <input type="text" name="nombres" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono" required>

        <button type="submit">Guardar</button>
    </form>
    <br>
    <a href="empleado.php">⬅ Volver</a>
</div>
</body>
</html>
